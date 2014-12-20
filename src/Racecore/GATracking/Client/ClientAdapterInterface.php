<?php

namespace Racecore\GATracking\Client;

interface ClientAdapterInterface
{
    public function __construct($options = array());
    public function send($url, $payload);
}
