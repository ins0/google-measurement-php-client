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

        // connect
        $connection = @fsockopen($port == 443 ? 'ssl://' . $endpoint['host'] : $endpoint['host'], $port, $error, $errorMessage, 10);

        if (!$connection || $error) {
            throw new Exception\EndpointServerException('Analytics Host not reachable! Error:' . $errorMessage);
        }

        if ($this->getOption('async')) {
            stream_set_blocking($connection, 0);
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
        if (!fwrite($this->connection, $header) || !fwrite($this->connection, $payloadString)) {
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
        while (!feof($this->connection)) {
            $response .= fread($this->connection, 8192);
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
        fclose($this->connection);

        return $requestCollection;
    }
}
