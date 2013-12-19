<?php
namespace Racecore\GATracking;

/**
 * Google Analytics Measurement PHP Class
 * Licensed under the 3-clause BSD License.
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * Google Documentation
 * https://developers.google.com/analytics/devguides/collection/protocol/v1/
 *
 * @author  Marco Rieger
 * @email   Rieger(at)racecore.de
 * @git     https://github.com/ins0
 * @url     http://www.racecore.de
 */
class GATracking
{
    /**
     * Google Analytics Account ID UA-...
     *
     * @var
     */
    private $accountID;

    /**
     * Current User Client ID
     *
     * @var string
     */
    private $clientID;

    /**
     * Protocol Version
     *
     * @var string
     */
    private $protocol = '1';

    /**
     * Analytics Endpoint URL
     *
     * @var string
     */
    private $analytics_endpoint = 'http://google-analytics.com/collect';

    /**
     * Tacking Holder
     *
     * @var array
     */
    private $event_holder = array();

    /**
     * Holds the last Response from Google Analytics Server
     *
     * @var string
     */
    private $last_response = array();

    /**
     * Sets the Analytics Account ID
     *
     * @author  Marco Rieger
     * @param $account
     */
    public function setAccountID($account)
    {

        $this->accountID = $account;
    }

    /**
     * Set the current Client ID
     *
     * @author  Marco Rieger
     * @param $clientID
     * @return $this
     */
    public function setClientID($clientID)
    {
        $this->clientID = $clientID;
        return $this;
    }

    /**
     * Returns the current Client ID
     *
     * @author  Marco Rieger
     * @return string
     */
    public function getClientID()
    {
        if (!$this->clientID) {
            $this->clientID = $this->createClientID();
        }

        return $this->clientID;
    }

    /**
     * Returns the last Response from Google Analytics Server
     *
     * @author  Marco Rieger
     * @return string
     */
    public function getLastResponse()
    {
        return $this->last_response;
    }


    /**
     * Create a GUID on Client specific values
     *
     * @author  Marco Rieger
     * @return string
     */
    private function createClientID()
    {
        //$uid = uniqid('', true);

        // collect user specific data
        if (isset($_COOKIE['__utma']) && $_COOKIE['__utma']) {

            $gaCookie = explode('.', $_COOKIE['__utma']);
            $clientId = (int)$gaCookie[1];

        } else {

            // some user specific values if no user client id is set
            $data = $_SERVER['REMOTE_ADDR'];
            //$data .= $_SERVER['HTTP_USER_AGENT'];

            $clientId = sprintf('%u', crc32($data));
        }

        // return client id
        return $clientId;
    }

    /**
     * Send all captured Events to Analytics Server
     *
     * @author  Marco Rieger
     */
    public function send()
    {

        /** @var AbstractTracking $event */
        foreach ($this->event_holder as $event) {

            $this->sendEvent($event);
        }

        return true;
    }

    /**
     * Returns the Client IP
     * The last octect of the IP address is removed to anonymize the user
     *
     * @author  Marco Rieger
     * @param $remoteAddress
     * @return string
     */
    function getClientIP($address = '')
    {

        if (!$address) {
            $address = $_SERVER['REMOTE_ADDR'];
        }

        if (!$address) {
            return '';
        }

        // Capture the first three octects of the IP address and replace the forth
        // with 0, e.g. 124.455.3.123 becomes 124.455.3.0
        $regex = "/^([^.]+\.[^.]+\.[^.]+\.).*/";
        if (preg_match($regex, $address, $matches)) {
            return $matches[1] . '0';
        }

        return '';
    }

    /**
     * Send the Event to GA
     *
     * @author  Marco Rieger
     * @param AbstractTracking $event
     */
    private function sendEvent(AbstractTracking $event)
    {

        // get packet
        $eventPacket = $event->getPaket();

        // Add Protocol
        $eventPacket['v'] = $this->protocol; // protocol version
        $eventPacket['tid'] = $this->accountID; // account id
        $eventPacket['cid'] = $this->getClientID(); // client id
        //$eventPacket['vid'] = $this->getClientID(); // visitor id
        //$eventPacket['ip'] = $this->getClientIP(); // client ip

        $eventPacket = array_reverse($eventPacket);

        // anti cache
        //$eventPacket['z'] = uniqid('cache_buster');

        // build query
        $content = http_build_query($eventPacket);

        // get endpoint
        $endpoint = parse_url($this->analytics_endpoint);

        // port
        $port = ($endpoint['scheme'] == 'https' ? 443 : 80);

        // connect
        $connection = @fsockopen($endpoint['scheme'] == 'https' ? 'ssl://' : '' . $endpoint['host'], $port, $error, $errorstr, 10);

        if (!$connection) {
            throw new Exception('Analytics Host not reachable!');
        }

        $header = 'POST ' . $endpoint['path'] . ' HTTP/1.1' . "\r\n" .
            'Host: ' . $endpoint['host'] . "\r\n" .
            'User-Agent: ' . $_SERVER['HTTP_USER_AGENT'] . "\r\n" .
            'Content-Type: application/x-www-form-urlencoded' . "\r\n" .
            'Content-Length: ' . strlen($content) . "\r\n" .
            'Connection: Close' . "\r\n\r\n";

        $this->last_response = '';

        // frwite data
        fwrite($connection, $header);
        fwrite($connection, $content);

        // response
        $response = '';

        // receive response
        while (!feof($connection)) {
            $response .= fgets($connection, 1024);
        }

        // response
        $responseContainer = explode("\r\n\r\n", $response, 2);
        $responseContainer[0] = explode("\r\n", $responseContainer[0]);

        // save last response
        $this->last_response[] = $responseContainer;

        // connection close
        fclose($connection);

        return true;
    }

    /**
     * Add Tracking Event
     *
     * @author  Marco Rieger
     * @param $event
     * @return $this
     */
    public function addTracking($event)
    {

        if ($event instanceof AbstractTracking) {

            $this->event_holder[] = $event;
        }

        return $this;
    }


}