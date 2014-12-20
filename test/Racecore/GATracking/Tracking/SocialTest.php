<?php

namespace Racecore\GATracking\Tracking;

use Racecore\GATracking\AbstractGATrackingTest;

/**
 * Class PageviewTest
 *
 * @author      Marco Rieger
 * @package       Racecore\GATracking\Tracking
 */
class SocialTest extends AbstractGATrackingTest
{

    private $social;

    public function setUp()
    {
        $this->social  = new Social();
    }

    public function testPaketEqualsSpecification()
    {
        /** @var Social $social */
        $social = $this->social;
        $social->setSocialAction('Test Action');
        $social->setSocialNetwork('Test Network');
        $social->setSocialTarget('/test-target');

        $packet = $social->getPackage();
        $this->assertArraysAreSimilar(
            array(
                't'     =>  'social',
                'sa'    =>  'Test Action',
                'sn'    =>  'Test Network',
                'st'    =>  '/test-target'
            ),
            $packet
        );
    }
}
