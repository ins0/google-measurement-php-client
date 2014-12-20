<?php

namespace Racecore\GATracking\Tracking;

use Racecore\GATracking\AbstractGATrackingTest;

/**
 * Class Event Test
 *
 * @author      Marco Rieger
 * @package     Racecore\GATracking\Tracking
 */
class EventTest extends AbstractGATrackingTest
{
    private $event;

    public function setUp()
    {
        $this->event  = new Event();
    }

    public function testPaketEqualsSpecification()
    {
        /** @var Event $event */
        $event = $this->event;
        $event->setEventCategory('foo');
        $event->setEventAction('bar');
        $event->setEventLabel('baz');
        $event->setEventValue('val');

        $packet = $event->getPackage();
        $this->assertArraysAreSimilar(
            array(
                't'     =>  'event',
                'ec'    =>  'foo',
                'ea'    =>  'bar',
                'el'    =>  'baz',
                'ev'    =>  'val'
            ),
            $packet
        );
    }
}
