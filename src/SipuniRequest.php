<?php

namespace Deadkash\SipuniBundle;


class SipuniRequest
{
    const SRC_TYPE_INNER = 1;
    const SRC_TYPE_OUTER = 2;
    const DST_TYPE_INNER = 1;
    const DST_TYPE_OUTER = 2;

    const EVENT_CALL = 1;
    const EVENT_HANGUP = 2;
    const EVENT_ANSWER = 3;
    const EVENT_SECONDARY_HANGUP = 4;

    /** @var array */
    private $data;

    /** @var string */
    private $callId;

    /** @var string */
    private $channel;

    /** @var string */
    private $dstNum;

    /** @var string */
    private $dstType;

    /** @var string */
    private $event;

    /** @var string */
    private $isInnerCall;

    /** @var string */
    private $shortDstNum;

    /** @var string */
    private $shortSrcNum;

    /** @var string */
    private $srcNum;

    /** @var string */
    private $srcType;

    /** @var string */
    private $timestamp;

    /** @var string */
    private $treeName;

    /** @var string */
    private $treeNumber;

    /** @var string */
    private $status;

    /** @var string */
    private $callStartTimestamp;

    /** @var string */
    private $callAnswerTimestamp;

    /** @var string */
    private $callRecordLink;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;

        if (isset($data['call_id'])) $this->setCallId($data['call_id']);
        if (isset($data['channel'])) $this->setChannel($data['channel']);
        if (isset($data['dst_num'])) $this->setDstNum($data['dst_num']);
        if (isset($data['dst_type'])) $this->setDstType($data['dst_type']);
        if (isset($data['event'])) $this->setEvent($data['event']);
        if (isset($data['is_inner_call'])) $this->setIsInnerCall($data['is_inner_call']);
        if (isset($data['short_dst_num'])) $this->setShortDstNum($data['short_dst_num']);
        if (isset($data['short_src_num'])) $this->setShortSrcNum($data['short_src_num']);
        if (isset($data['src_num'])) $this->setSrcNum($data['src_num']);
        if (isset($data['src_type'])) $this->setSrcType($data['src_type']);
        if (isset($data['timestamp'])) $this->setTimestamp($data['timestamp']);
        if (isset($data['treeName'])) $this->setTreeName($data['treeName']);
        if (isset($data['treeNumber'])) $this->setTreeNumber($data['treeNumber']);
        if (isset($data['status'])) $this->setStatus($data['status']);
        if (isset($data['call_start_timestamp'])) $this->setCallStartTimestamp($data['call_start_timestamp']);
        if (isset($data['call_answer_timestamp'])) $this->setCallAnswerTimestamp($data['call_answer_timestamp']);
        if (isset($data['call_record_link'])) $this->setCallRecordLink($data['call_record_link']);
    }

    /**
     * @return string
     */
    public function getTreeNumber()
    {
        return $this->treeNumber;
    }

    /**
     * @param string $treeNumber
     */
    public function setTreeNumber($treeNumber)
    {
        $this->treeNumber = $treeNumber;
    }

    /**
     * @return string
     */
    public function getTreeName()
    {
        return $this->treeName;
    }

    /**
     * @param string $treeName
     */
    public function setTreeName($treeName)
    {
        $this->treeName = $treeName;
    }

    /**
     * @return string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param string $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return string
     */
    public function getSrcType()
    {
        return $this->srcType;
    }

    /**
     * @param string $srcType
     */
    public function setSrcType($srcType)
    {
        $this->srcType = $srcType;
    }

    /**
     * @return string
     */
    public function getSrcNum()
    {
        return $this->srcNum;
    }

    /**
     * @param string $srcNum
     */
    public function setSrcNum($srcNum)
    {
        $this->srcNum = $srcNum;
    }

    /**
     * @return string
     */
    public function getShortSrcNum()
    {
        return $this->shortSrcNum;
    }

    /**
     * @param string $shortSrcNum
     */
    public function setShortSrcNum($shortSrcNum)
    {
        $this->shortSrcNum = $shortSrcNum;
    }

    /**
     * @return string
     */
    public function getShortDstNum()
    {
        return $this->shortDstNum;
    }

    /**
     * @param string $shortDstNum
     */
    public function setShortDstNum($shortDstNum)
    {
        $this->shortDstNum = $shortDstNum;
    }

    /**
     * @return string
     */
    public function getIsInnerCall()
    {
        return $this->isInnerCall;
    }

    /**
     * @param string $isInnerCall
     */
    public function setIsInnerCall($isInnerCall)
    {
        $this->isInnerCall = $isInnerCall;
    }

    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param string $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * @return string
     */
    public function getDstType()
    {
        return $this->dstType;
    }

    /**
     * @param string $dstType
     */
    public function setDstType($dstType)
    {
        $this->dstType = $dstType;
    }

    /**
     * @return string
     */
    public function getDstNum()
    {
        return $this->dstNum;
    }

    /**
     * @param string $dstNum
     */
    public function setDstNum($dstNum)
    {
        $this->dstNum = $dstNum;
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param string $channel
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
    }

    /**
     * @return string
     */
    public function getCallId()
    {
        return $this->callId;
    }

    /**
     * @param string $callId
     */
    public function setCallId($callId)
    {
        $this->callId = $callId;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getCallStartTimestamp()
    {
        return $this->callStartTimestamp;
    }

    /**
     * @param string $callStartTimestamp
     */
    public function setCallStartTimestamp($callStartTimestamp)
    {
        $this->callStartTimestamp = $callStartTimestamp;
    }

    /**
     * @return string
     */
    public function getCallAnswerTimestamp()
    {
        return $this->callAnswerTimestamp;
    }

    /**
     * @param string $callAnswerTimestamp
     */
    public function setCallAnswerTimestamp($callAnswerTimestamp)
    {
        $this->callAnswerTimestamp = $callAnswerTimestamp;
    }

    /**
     * @return string
     */
    public function getCallRecordLink()
    {
        return $this->callRecordLink;
    }

    /**
     * @param string $callRecordLink
     */
    public function setCallRecordLink($callRecordLink)
    {
        $this->callRecordLink = $callRecordLink;
    }
}