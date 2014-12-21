<?php

namespace Racecore\GATracking;

/**
 * Class GATrackingTest
 *
 * @author      Marco Rieger
 * @package       Racecore\GATracking
 */
class GATrackingTest extends AbstractGATrackingTest
{

    /** @var  GATracking */
    private $instance;

    public function setUp()
    {
        $clientMock = $this->getClientMock();
        $this->instance = new GATracking('foo', null, $clientMock);
    }

    public function getClientMock()
    {
        $clientMock = $this->getMock('GATracking\Client\CurlClient');
        return $clientMock;
    }

    public function testInstanceIsGenerated()
    {
        $this->assertInstanceOf('Racecore\GATracking\GATracking', $this->instance);
    }
}
