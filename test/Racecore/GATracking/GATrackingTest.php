<?php
namespace Racecore\GATracking;

use Racecore\GATracking\Tracking\Ecommerce as Ecommerce;
use Racecore\GATracking\Tracking\Pageview;
use Racecore\GATracking\Tracking\Campaign;

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
        $eventTransaction = new Ecommerce\Transaction();
        $eventItem = new Ecommerce\Item();

        $tracking->addTracking( $eventPageview );
        $tracking->addTracking( $eventCampaign );
        $tracking->addTracking( $eventTransaction );
        $tracking->addTracking( $eventItem );

        $events = $tracking->getEvents();

        $this->assertEquals( 4, count($events));
        $this->assertEquals($eventPageview, $events[0] );
        $this->assertEquals($eventCampaign, $events[1] );
        $this->assertEquals($eventTransaction, $events[2] );
        $this->assertEquals($eventItem, $events[3] );
    }

    public function testClientIDisGeneratedFromGoogleCookie(){

        $tracking = $this->tracking;

        $_COOKIE['_ga'] = 'GA1.3.123456789.1234567890';
        $clientID = $tracking->getClientID();

        $this->assertEquals('123456789.1234567890', $clientID);
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
 