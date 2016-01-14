<?php

namespace Racecore\GATracking\Client\Adapter;

use Racecore\GATracking\Client;
use Racecore\GATracking\Exception;
use Racecore\GATracking\Request;

class Socket extends Client\AbstractClientAdapter
{
    private $connection = null;

    /**
     * Create Connection to the Google Server
     * @param $endpoint
     * @throws Exception\EndpointServerException
     */
    private function createConenction($endpoint)
    {
        // port
        $port = $this->getOption('ssl') == true ? 443 : 80;


        $connection = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_connect($connection, $endpoint['host'], $port);

        if (!$connection) {
            throw new Exception\EndpointServerException('Analytics Host not reachable! Error:');
        }

        $this->connection = $connection;
    }

    /**
     * Write the connection header
     * @param $endpoint
     * @param Request\TrackingRequest $request
     * @param bool $lastData
     * @return string
     * @throws Exception\EndpointServerException
     */
    private function writeHeader($endpoint, Request\TrackingRequest $request, $lastData = false)
    {
        // create data
        $payloadString = http_build_query($request->getPayload());
        $payloadLength = strlen($payloadString);

        $header =   'POST ' . $endpoint['path'] . ' HTTP/1.1' . "\r\n" .
            'Host: ' . $endpoint['host'] . "\r\n" .
            'User-Agent: Google-Measurement-PHP-Client' . "\r\n" .
            'Content-Length: ' . $payloadLength . "\r\n" .
            ($lastData ? 'Connection: Close' . "\r\n" : '') . "\r\n";

        // fwrite + check if fwrite was ok
        if (!socket_write($this->connection, $header) || !socket_write($this->connection, $payloadString)) {
            throw new Exception\EndpointServerException('Server closed connection unexpectedly');
        }

        return $header;
    }

    /**
     * Read from the current connection
     * @param Request\TrackingRequest $request
     * @return array|false
     */
    private function readConnection(Request\TrackingRequest $request)
    {
        if ($this->getOption('async')) {
            return false;
        }

        // response
        $response = '';

        // receive response
        while ($out = socket_read($this->connection, 2048)) {
            $response .= $out;

            if (strlen($out) < 2048) {
                break;
            }
        }

        // response
        $responseContainer = explode("\r\n\r\n", $response, 2);
        return explode("\r\n", $responseContainer[0]);
    }

    /**
     * Send the Request Collection to a Server
     * @param $url
     * @param Request\TrackingRequestCollection $requestCollection
     * @return Request\TrackingRequestCollection|void
     * @throws Exception\EndpointServerException
     */
    public function send($url, Request\TrackingRequestCollection $requestCollection)
    {
        // get endpoint
        $endpoint = parse_url($url);

        $this->createConenction($endpoint);

        /** @var Request\TrackingRequest $request */
        while ($requestCollection->valid()) {
            $request = $requestCollection->current();
            $requestCollection->next();

            $this->writeHeader($endpoint, $request, !$requestCollection->valid());
            $responseHeader = $this->readConnection($request);

            $request->setResponseHeader($responseHeader);
        }
        // connection close
        socket_close($this->connection);

        return $requestCollection;
    }
}
