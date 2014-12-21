<?php

namespace Racecore\GATracking\Tracking\App;

use Racecore\GATracking\AbstractGATrackingTest;

/**
 * Class ScreenTest
 *
 * @author      Marco Rieger
 * @package     Racecore\GATracking\Tracking\App
 */
class ScreenTest extends AbstractGATrackingTest
{
    /**
     * @var Screen
     */
    private $screen;

    public function setUp()
    {
        $this->screen  = new Screen();
    }

    public function testPaketEqualsSpecification()
    {
        $screen = $this->screen;

        $screen->setAppName('Test App');
        $screen->setAppVersion('1.0');
        $screen->setContentDescription('Test Description');

        $packet = $screen->getPackage();

        $this->assertArraysAreSimilar(
            array(
                't' => 'appview',
                'an' => 'Test App',
                'av' => '1.0',
                'cd' => 'Test Description'
            ),
            $packet
        );
    }
}
