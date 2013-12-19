<?php
namespace Racecore\GATracking;
use Racecore\GATracking\Tracking\Campaign;
use Racecore\GATracking\Tracking\Pageview;

/**
 * Class GATrackingTest
 *
 * @author      Marco Rieger
 * @package       Racecore\GATracking
 */
class GATrackingTest extends \PHPUnit_Framework_TestCase {

    /** @var  GATracking */
    private $tracking;

    public function setUp()
    {
        $this->tracking = new GATracking();
    }

    public function testTrackingEventsCanAddedToTheStack()
    {
        $tracking = $this->tracking;

        $eventPageview = new Pageview();
        $eventCampaign = new Campaign();

        $tracking->addTracking( $eventPageview );
        $tracking->addTracking( $eventCampaign );

        $events = $tracking->getEvents();

        $this->assertEquals( 2, count($events));
        $this->assertEquals($eventPageview, $events[0] );
        $this->assertEquals($eventCampaign, $events[1] );
    }

    public function testClientIDisGeneratedFromRemoteAddress(){

        $tracking = $this->tracking;

        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $clientID = $tracking->getClientID();

        $this->assertEquals('3619153832', $clientID);
    }

    public function testClientIDisGeneratedFromGoogleCookie(){

        $tracking = $this->tracking;

        $_COOKIE['__utma'] = 'foo.1234567890';
        $clientID = $tracking->getClientID();

        $this->assertEquals('1234567890', $clientID);
    }

    public function testAccountIDcanSet()
    {
        $tracking = $this->tracking;
        $tracking->setAccountID('foo');

        $accountID = $tracking->getAccountID();
        $this->assertEquals('foo', $accountID);
    }

    public function testLastResponseIsStoredInContainer()
    {
        $tracking = $this->tracking;
        $tracking->addResponse('foo');

        $last_response = $tracking->getLastResponse();
        $this->assertEquals('foo', $last_response);

        $tracking->addResponse('bar');
        $last_response_stack = $tracking->getLastResponseStack();
        $this->assertEquals(array('foo', 'bar'), $last_response_stack );
    }


}
 