<?php

namespace Deadkash\SipuniBundle\Service;


use Deadkash\SipuniBundle\SipuniRequest;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ZMQ;
use ZMQContext;

class SipuniService
{
    const ZMQ_HOST = "127.0.0.1";
    const ZMQ_PORT = "5555";
    const SIPUNI_LOGIN = '';
    const SIPUNI_SECRET_KEY = '';
    const SIPUNI_WEBSOCKET_KEY = '';
    const SIPUNI_WEBSOCKET_URL = 'wss://sipuni.com:8083/';

    /** @var ContainerInterface */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param $request
     */
    public function receiveRequest($request)
    {
        $entryData = $request->query->all();
        $sipuniRequest = new SipuniRequest($entryData);

        $output = array(
            'short_dst_num' => $sipuniRequest->getShortDstNum()
        );

        switch($sipuniRequest->getEvent()) {

            case SipuniRequest::EVENT_CALL:
                $output['event'] = 'call';
                $output['source'] = $sipuniRequest->getSrcNum();
                $output['call_id'] = $sipuniRequest->getCallId();
                break;

            case SipuniRequest::EVENT_ANSWER:
                $output['event'] = 'answer';
                $output['source'] = $sipuniRequest->getSrcNum();
                $output['call_id'] = $sipuniRequest->getCallId();
                break;

            case SipuniRequest::EVENT_HANGUP:
                $output['event'] = 'hangup';
                $output['source'] = $sipuniRequest->getSrcNum();
                $output['call_id'] = $sipuniRequest->getCallId();
                break;

            case SipuniRequest::EVENT_SECONDARY_HANGUP:
                $output['event'] = 'secondary_hangup';
                $output['source'] = $sipuniRequest->getSrcNum();
                $output['call_id'] = $sipuniRequest->getCallId();
                break;
        }

        $context = new ZMQContext();
        $socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'apicall_pusher');
        $socket->connect('tcp://' . self::ZMQ_HOST . ':' . self::ZMQ_PORT);
        $socket->send(json_encode($output));
    }

    /**
     * @param $phone
     * @return mixed
     */
    public function clearPhone($phone)
    {
        $phone = str_replace('+7', '8', $phone);
        return preg_replace('/[^0-9]/', '', $phone);
    }

    /**
     * @param $source
     * @param $destination
     * @return mixed
     */
    public function callback($source, $destination)
    {
        $user = self::SIPUNI_LOGIN;
        $phone = $this->clearPhone($destination);
        $reverse = '0';
        $antiaon = '0';
        $sipnumber = $source;
        $secret = self::SIPUNI_SECRET_KEY;

        $hashString = join('+', array($antiaon, $phone, $reverse, $sipnumber, $user, $secret));
        $hash = md5($hashString);

        $url = 'http://sipuni.com/api/callback/call_number';
        $query = http_build_query(array(
            'antiaon' => $antiaon,
            'phone' => $phone,
            'reverse' => $reverse,
            'sipnumber' => $sipnumber,
            'user' => $user,
            'hash' => $hash
        ));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output, true);
    }
}