<?php

namespace Racecore\GATracking\Client\Adapter;

use Racecore\GATracking\Client;
use Racecore\GATracking\Exception;
use Racecore\GATracking\Request;

class Socket extends Client\AbstractClientAdapter
{
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

        // port
        $port = $this->getOption('use_ssl') == true ? 443 : 80;

        // connect
        $connection = @fsockopen($port == 443 ? 'ssl://' . $endpoint['host'] : $endpoint['host'], $port, $error, $errorMessage, 10);

        if (!$connection || $error) {
            throw new Exception\EndpointServerException('Analytics Host not reachable! Error:' . $errorMessage);
        }

        /** @var Request\TrackingRequest $request */
        while ($requestCollection->valid()) {
            $request = $requestCollection->current();

            // create data
            $payloadString = http_build_query($request->getPayload());
            $payloadLength = strlen($payloadString);

            $requestCollection->next();

            $header =   'POST ' . $endpoint['path'] . ' HTTP/1.1' . "\r\n" .
                'Host: ' . $endpoint['host'] . "\r\n" .
                'User-Agent: Google-Measurement-PHP-Client' . "\r\n" .
                'Content-Length: ' . $payloadLength . "\r\n" .
                (!$requestCollection->valid() ? 'Connection: Close' . "\r\n" : '') . "\r\n";

            // fwrite + check if fwrite was ok
            if (!fwrite($connection, $header) || !fwrite($connection, $payloadString)) {
                throw new Exception\EndpointServerException('Server closed connection unexpectedly');
            }

            // response
            $response = '';

            // receive response
            $read = 0;
            do {
                $buf = fread($connection, $payloadLength - $read);
                $read += strlen($buf);
                $response .= $buf;
            } while ($read < $payloadLength);

            // response
            $responseContainer = explode("\r\n\r\n", $response, 2);
            $responseHeader = explode("\r\n", $responseContainer[0]);

            $request->setResponseHeader($responseHeader);
        }

        // connection close
        fclose($connection);

        return $requestCollection;
    }
}
