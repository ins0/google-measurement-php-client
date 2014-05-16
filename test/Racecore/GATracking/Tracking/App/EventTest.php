<?php
namespace Racecore\GATracking\Tracking\App;

/**
 * Class Event App Test
 *
 * @author      Marco Rieger
 * @package     Racecore\GATracking\Tracking\App
 */
class EventTest extends \PHPUnit_Framework_TestCase {

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

        $packet = $event->getPaket();

        $this->assertSame(
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
 