<?php
namespace Racecore\GATracking\Tracking;

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
 * @author  Enea Berti
 * @email   reysharks(at)gmail.com
 * @git     https://github.com/reysharks
 * @url     http://www.adacto.it
 * @package Racecore\GATracking\Tracking
 */
class Transaction extends AbstractTracking
{

    private $id = 0;
    private $affiliation = '';
    private $revenue = 0;
    private $shipping = 0;
    private $tax = 0;
    private $currency = '';
    private $host = '';

    /**
     * Set the Transaction ID
     *
     * @author  Enea Berti
     * @param $id
     */
    public function setID($id)
    {

        $this->id = $id;
    }

    /**
     * Returns the Transaction ID
     *
     * @author  Enea Berti
     * @return integer
     */
    public function getID()
    {

        if (!$this->id) {
            return '/';
        }

        return $this->id;
    }

    /**
     * Sets the Affiliation
     *
     * @author  Enea Berti
     * @param $affiliation
     */
    public function setAffiliation($affiliation)
    {

        $this->affiliation = $affiliation;
    }

    /**
     * Return Affiliation
     *
     * @author  Enea Berti
     * @return string
     */
    public function getAffiliation()
    {

        return $this->affiliation;
    }

    /**
     * Sets the Revenue
     *
     * @author  Enea Berti
     * @param $revenue
     */
    public function setRevenue($revenue)
    {
        $this->revenue = $revenue;
    }

    /**
     * Return the Revenue
     *
     * @return float
     */
    public function getRevenue()
    {
        return $this->revenue;
    }

    /**
     * Sets the Shipping
     *
     * @author  Enea Berti
     * @param $shipping
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;
    }

    /**
     * Return Shipping
     *
     * @return float
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * Sets the Tax
     *
     * @author  Enea Berti
     * @param $tax
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    /**
     * Return the Tax
     *
     * @return float
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Sets the Currency
     *
     * @author  Enea Berti
     * @param $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * Return the Currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Return the Transaction Host Address
     *
     * @author  Enea Berti
     * @param $host
     * @return $this
     */
    public function setTransactionHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionHost()
    {
        return $this->host;
    }

    /**
     * Returns the Google Paket for Transaction Tracking
     *
     * @author  Enea Berti
     * @return array
     */
    public function getPaket()
    {
        /*
        &t=transaction   // Transaction hit type.
        &ti=12345        // transaction ID. Required.
        &ta=westernWear  // Transaction affiliation.
        &tr=50.00        // Transaction revenue.
        &ts=32.00        // Transaction shipping.
        &tt=12.00        // Transaction tax.
        &cu=EUR          // Currency code.
        */
        return array(
            't' => 'transaction',
            'ti' => $this->getID(),
            'ta' => $this->getAffiliation(),
            'tr' => $this->getRevenue(),
            'ts' => $this->getShipping(),
            'tt' => $this->getTax(),
            'dh' => $this->getTransactionHost(),
            'cu' => $this->getCurrency()
        );
    }

}