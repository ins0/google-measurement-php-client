<?php
namespace Racecore\GATracking\Tracking;

/**
 * Class Event Test
 *
 * @author      Marco Rieger
 * @package     Racecore\GATracking\Tracking
 */
class EventTest extends \PHPUnit_Framework_TestCase {

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
        $this->assertSame(
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

    public function testGetterSetter()
    {
        /** @var Event $event */
        $event = $this->event;

        $event->setEventCategory('foo');
        $this->assertEquals('foo', $event->getEventCategory() );

        $event->setEventAction('bar');
        $this->assertEquals('bar', $event->getEventAction() );

        $event->setEventLabel('baz');
        $this->assertEquals('baz', $event->getEventLabel() );

        $event->setEventValue('val');
        $this->assertEquals('val', $event->getEventValue() );
    }

}
 