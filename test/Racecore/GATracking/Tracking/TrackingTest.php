<?php

namespace Racecore\GATracking\Tracking;

use Racecore\GATracking\AbstractGATrackingTest;

/**
 * Class TrackingTest
 *
 * @package       Racecore\GATracking\Tracking
 */
class TrackingTest extends AbstractGATrackingTest
{
    public function testCanSetTrackingProcessingTime()
    {
        $timeProcessed = new \DateTime();
        $timeProcessed->modify('-1 hour');

        $event = new Event();
        $event->setEventCategory('foo');
        $event->setEventAction('bar');
        $event->setProcessingTime($timeProcessed->getTimestamp());

        $package = $event->getPackage();
        $this->assertEquals(3600000, $package['qt']);
    }

    public function testTrackingProcessingTimeIsNotSetWhenInvalid()
    {
        $timeProcessed = new \DateTime();
        $timeProcessed->modify('+1 hour');

        $event = new Event();
        $event->setEventCategory('foo');
        $event->setEventAction('bar');
        $event->setProcessingTime($timeProcessed->getTimestamp());

        $package = $event->getPackage();
        $this->assertArrayNotHasKey('qt', $package);
    }

    public function testTrackingProcessingTimeThrowsNoticeWhenOver4Hours()
    {
        $this->setExpectedException('PHPUnit_Framework_Error_Notice', 'Queue Time greater than 4 hours. Values greater than four hours may lead to hits not being processed!');

        $timeProcessed = new \DateTime();
        $timeProcessed->modify('-4 hours');

        $event = new Event();
        $event->setEventCategory('foo');
        $event->setEventAction('bar');
        $event->setProcessingTime($timeProcessed->getTimestamp());

        $package = $event->getPackage();
        $this->assertEquals(0, $package['qt']);
    }
}
