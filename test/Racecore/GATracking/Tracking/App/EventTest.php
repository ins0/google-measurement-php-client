<?php

namespace Racecore\GATracking\Tracking\App;

use Racecore\GATracking\AbstractGATrackingTest;

/**
 * Class Event App Test
 *
 * @author      Marco Rieger
 * @package     Racecore\GATracking\Tracking\App
 */
class EventTest extends AbstractGATrackingTest
{
    /**
     * @var Event
     */
    private $event;

    public function setUp()
    {
        $this->event  = new Event();
    }

    public function testPaketEqualsSpecification()
    {
        $event = $this->event;

        $event->setAppName('Test App');
        $event->setEventAction('Test Action');
        $event->setEventCategory('Test Category');

        $packet = $event->getPackage();

        $this->assertArraySimilar(
            array(
                't' => 'event',
                'an' => 'Test App',
                'ec' => 'Test Category',
                'ea' => 'Test Action'
            ),
            $packet
        );
    }

}
