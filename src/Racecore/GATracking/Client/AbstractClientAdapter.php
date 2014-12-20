<?php

namespace Racecore\GATracking\Client;

class AbstractClientAdapter implements ClientAdapterInterface
{
    private $options = array();

    public function __construct($options = array())
    {
        $this->options = $options;
    }

    public function send($url, $payload)
    {

    }
}
