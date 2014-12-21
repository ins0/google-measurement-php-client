<?php

namespace Racecore\GATracking\Request;

use Racecore\GATracking\Tracking;

class TrackingRequest
{
    private $payload;
    private $responseHeader;

    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param mixed $payload
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return mixed
     */
    public function getResponseHeader()
    {
        return $this->responseHeader;
    }

    /**
     * @param mixed $responseHeader
     */
    public function setResponseHeader($responseHeader)
    {
        $this->responseHeader = $responseHeader;
    }
}
