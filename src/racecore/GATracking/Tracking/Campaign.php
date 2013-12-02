<?php
namespace Racecore\GATracking\Tracking;

/**
 * Google Analytics Measurement PHP Class
 * Licensed under the 3-clause BSD License.
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 * Google Documentation
 * https://developers.google.com/analytics/devguides/collection/protocol/v1/
 * @author  Marco Rieger
 * @email   Rieger(at)racecore.de
 * @git     https://github.com/ins0
 * @url     http://www.racecore.de
 */
class Campaign extends Pageview
{

    /**
     * Campaign Name
     * @var string
     */
    private $name;

    /**
     * Campaign Source
     * @var string
     */
    private $source;

    /**
     * Campaign Medium
     * @var string
     */
    private $medium;

    /**
     * Campaign Keywords
     * @var array
     */
    private $keywords = array();

    /**
     * Campaign Content
     * @var string
     */
    private $content;

    /**
     * Campaign ID
     * @var integer
     */
    private $cid;

    /**
     * Sets the Campaign ID
     *
     * @author  Marco Rieger
     * @param $cid
     * @return $this
     */
    public function setCampaignID($cid)
    {
        $this->cid = $cid;
        return $this;
    }

    /**
     * Returns the Campaign ID
     *
     * @author  Marco Rieger
     * @return int
     */
    public function getCampaignID()
    {
        return $this->cid;
    }

    /**
     * Sets the Campaign Content Description
     *
     * @author  Marco Rieger
     * @param $content
     * @return $this
     */
    public function setCampaignContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Gets the Campaign Content Description
     *
     * @author  Marco Rieger
     * @return string
     */
    public function getCampaignContent()
    {
        return $this->content;
    }

    /**
     * Sets the Campaign Keywords
     *
     * @author  Marco Rieger
     * @param $keywords
     * @return $this
     */
    public function setCampaignKeywords($keywords)
    {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * Return the Campaign Keywords
     *
     * @author  Marco Rieger
     * @return array
     */
    public function getCampaignKeywords()
    {
        return $this->keywords;
    }

    /**
     * Sets the Campaign Medium
     *
     * @author  Marco Rieger
     * @param $medium
     * @return $this
     */
    public function setCampaignMedium($medium)
    {
        $this->medium = $medium;
        return $this;
    }

    /**
     * Gets the Campaign Medium
     *
     * @author  Marco Rieger
     * @return string
     */
    public function getCampaignMedium()
    {
        return $this->medium;
    }

    /**
     * Sets the Campaign Name
     *
     * @author  Marco Rieger
     * @param $name
     * @return $this
     */
    public function setCampaignName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the Campaign Name
     *
     * @author  Marco Rieger
     * @return string
     */
    public function getCampaignName()
    {
        return $this->name;
    }

    /**
     * Sets the Campaign Source
     *
     * @author  Marco Rieger
     * @param $source
     * @return $this
     */
    public function setCampaignSource($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Get the Campaign Source
     *
     * @author  Marco Rieger
     * @return string
     */
    public function getCampaignSource()
    {
        return $this->source;
    }

    /**
     * Returns the POST Vars
     *
     * @author  Marco Rieger
     * @return array
     */
    public function getPaket()
    {

        $packet = parent::getPaket();

        if (!$this->getCampaignName()) {
            throw new Exception('Campaign Name musst be set');
        }

        if (!$this->getCampaignMedium()) {
            throw new Exception('Campaign Medium musst be set');
        }

        if (!$this->getCampaignSource()) {
            throw new Exception('Campaign Source musst be set');
        }

        return array_merge($packet, array(
            'cn' => $this->getCampaignName(),
            'cs' => $this->getCampaignSource(),
            'cm' => $this->getCampaignMedium(),
            'ck' => implode(';', $this->getCampaignKeywords()),
            'cc' => $this->getCampaignContent(),
            'ci' => $this->getCampaignID()
        ));
    }


}