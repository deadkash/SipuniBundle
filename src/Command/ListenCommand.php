<?php

namespace Deadkash\SipuniBundle\Command;

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\Wamp\WampServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory;
use React\Socket\Server;
use React\ZMQ\Context;
use Deadkash\SipuniBundle\Service\SipuniService;
use Deadkash\SipuniBundle\SipuniPusher;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZMQ;

class ListenCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('sipuni:listen');
    }

    /**
     * @return int|mixed
     */
    public function getSocketPort()
    {
        $container = $this->getContainer();
        return ($container->hasParameter('sipuni_daemon_port')) ?
            $container->getParameter('sipuni_daemon_port') : 8081;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \React\Socket\ConnectionException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loop   = Factory::create();
        $pusher = new SipuniPusher($this->getContainer());

        $context = new Context($loop);
        $pull = $context->getSocket(ZMQ::SOCKET_PULL);
        $pull->bind('tcp://'.SipuniService::ZMQ_HOST.':'.SipuniService::ZMQ_PORT);
        $pull->on('message', array($pusher, 'onApiCall'));

        $webSock = new Server($loop);
        $webSock->listen($this->getSocketPort(), '0.0.0.0');
        $webServer = new IoServer(
            new HttpServer(
                new WsServer(
                    new WampServer(
                        $pusher
                    )
                )
            ),
            $webSock
        );

        $loop->run();
    }
}