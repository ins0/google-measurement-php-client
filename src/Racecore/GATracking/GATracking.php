<?php

namespace Racecore\GATracking;

use Racecore\GATracking\Client;
use Racecore\GATracking\Exception;
use Racecore\GATracking\Tracking;

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
 * @package Racecore\GATracking\Tracking
 */
class GATracking
{
    private $analyticsAccountUid = null;
    private $options = array();

    /** @var AbstractClientAdapter */
    private $clientAdapter = null;

    private $apiProtocolVersion = '1';
    private $apiEndpointUrl = 'www.google-analytics.com/collect';

    /**
     * @param $analyticsAccountUid
     * @param array $options
     * @param Client\AbstractClientAdapter $clientAdapter
     * @throws Exception\InvalidArgumentException
     */
    public function __construct($analyticsAccountUid, $options = array(), Client\AbstractClientAdapter $clientAdapter = null)
    {
        if (empty($analyticsAccountUid)) {
            throw new Exception\InvalidArgumentException('Google Account/Tracking ID not provided');
        }

        $this->analyticsAccountUid = $analyticsAccountUid;

        if (!$clientAdapter) {
            $clientAdapter = new Client\Adapter\Socket();
        }
        $this->setClientAdapter($clientAdapter);

        if (!empty($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * Get the current Client Adapter
     * @return Client\AbstractClientAdapter
     */
    public function getClientAdapter()
    {
        return $this->clientAdapter;
    }

    /**
     * Set the current Client Adapter
     * @param Client\AbstractClientAdapter $adapter
     */
    public function setClientAdapter(Client\AbstractClientAdapter $adapter)
    {
        $this->clientAdapter = $adapter;
    }

    /**
     * Set Options
     *
     * @param $options
     * @throws Exception\InvalidArgumentException
     */
    public function setOptions($options)
    {
        if (!is_array($options)) {
            throw new Exception\InvalidArgumentException(sprintf(
                '[%s] expects array; received [%s]',
                __METHOD__,
                gettype($options)
            ));
        }

        $this->options = $options;
    }

    /**
     * Return Class Options
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get Single Option
     * @param $key
     * @return null|mixed
     */
    public function getOption($key)
    {
        if (!isset($this->options[$key])) {
            return null;
        }

        return $this->options[$key];
    }

    /**
     * Build the Tracking Payload Data
     * @param Tracking\AbstractTracking $event
     * @return array
     * @throws Exception\InvalidOptionException
     */
    protected function getTrackingPayloadData(Tracking\AbstractTracking $event)
    {
        $payloadData = $event->getPackage();
        $payloadData['v'] = $this->apiProtocolVersion; // protocol version
        $payloadData['tid'] = $this->analyticsAccountUid; // account id
        $payloadData['uid'] = $this->getOption('user_id');
        $payloadData['cid'] = $this->getOption('client_id');

        $proxy = $this->getOption('proxy');
        if ($proxy) {
            if (!isset($proxy['ip']) || !isset($proxy['user_agent'])) {
                throw new Exception\InvalidOptionException('proxy options need "ip" and "user_agent" keys');
            }

            $payloadData['uid'] = $proxy['ip'];
            $payloadData['ua'] = $proxy['user_agent'];
        }

        return array_filter($payloadData);
    }

    public function sendTracking(Tracking\AbstractTracking $tracking)
    {
        $clientAdapter = $this->clientAdapter;
        $payloadData = $this->getTrackingPayloadData($tracking);

        $clientAdapter->send($this->apiEndpointUrl, $payloadData);
    }
}
