<?php

namespace Deadkash\SipuniBundle;


use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SipuniPusher implements WampServerInterface
{

    /** @var ContainerInterface */
    private $container;

    /** @var array */
    protected $subscribedTopics = array();

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param ConnectionInterface $conn
     * @param \Ratchet\Wamp\Topic|string $topic
     */
    public function onUnSubscribe(ConnectionInterface $conn, $topic) {}

    /**
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn) {}

    /**
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn) {}

    /**
     * @param ConnectionInterface $conn
     * @param string $id
     * @param \Ratchet\Wamp\Topic|string $topic
     * @param array $params
     */
    public function onCall(ConnectionInterface $conn, $id, $topic, array $params)
    {
        $conn->callError($id, $topic, 'You are not allowed to make calls')->close();
    }

    /**
     * @param ConnectionInterface $conn
     * @param \Ratchet\Wamp\Topic|string $topic
     * @param string $event
     * @param array $exclude
     * @param array $eligible
     */
    public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible)
    {
        $conn->close();
    }

    /**
     * @param ConnectionInterface $conn
     * @param \Exception $e
     */
    public function onError(ConnectionInterface $conn, \Exception $e) {}

    /**
     * @param ConnectionInterface $conn
     * @param \Ratchet\Wamp\Topic|string $topic
     */
    public function onSubscribe(ConnectionInterface $conn, $topic)
    {
        $this->subscribedTopics[$topic->getId()] = $topic;
    }

    /**
     * @param $entry
     */
    public function onApiCall($entry)
    {
        $entryData = json_decode($entry, true);

        $shortDstNum = (isset($entryData['short_dst_num'])) ? $entryData['short_dst_num'] : false;
        if (!$shortDstNum) return;

        /** @var \Ratchet\Wamp\Topic $topic */
        $topic = (isset($this->subscribedTopics['apiCall' . $shortDstNum])) ?
            $this->subscribedTopics['apiCall' . $shortDstNum] : false;

        if (!$topic) return;
        $topic->broadcast($entryData);
    }

}