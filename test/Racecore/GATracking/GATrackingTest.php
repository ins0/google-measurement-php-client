<?php

namespace Racecore\GATracking;

use Racecore\GATracking\Request\TrackingRequest;
use Racecore\GATracking\Request\TrackingRequestCollection;

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
        $this->instance = new GATracking('fooId');
    }

    public function getClientMock()
    {
        $class = $this->getMock('Racecore\GATracking\Client\Adapter\Socket');
        return $class;
    }

    public function testInstanceIsGenerated()
    {
        $this->assertInstanceOf('Racecore\GATracking\GATracking', $this->instance);
    }

    public function testAnalyticsAccountIdIsSet()
    {
        $this->assertSame('fooId', $this->instance->getAnalyticsAccountUid());
    }

    public function testAnalyticsAccountIdCanBeSet()
    {
        $this->instance->setAnalyticsAccountUid('newFoo');
        $this->assertSame('newFoo', $this->instance->getAnalyticsAccountUid());
    }

    public function testSetUpClientAdapterFromConstructor()
    {
        $this->assertInstanceOf(
            'Racecore\GATracking\Client\AbstractClientAdapter',
            $this->instance->getClientAdapter()
        );
    }

    public function testDefaultClientAdapterIsSet()
    {
        $instance = new GATracking('foo');
        $this->assertInstanceOf('Racecore\GATracking\Client\Adapter\Socket', $instance->getClientAdapter());
    }

    public function testOptionsAreMergedOverConstructor()
    {
        $options = array(
            'foo' => 'bar',
            'baz' => array(
                'foobaz' => 'foobar'
            )
        );
        $instance = new GATracking('foo', $options);
        $newOptions = $instance->getOptions();

        $this->assertArrayHasKey('foo', $newOptions);
        $this->assertArrayHasKey('baz', $newOptions);
        $this->assertArrayHasKey('foobaz', $newOptions['baz']);

        $this->assertSame('bar', $newOptions['foo']);
    }

    public function testOptionsCanSetOverMethod()
    {
        $options = array(
            'foo' => 'bar',
            'baz' => array(
                'foobaz'
            )
        );
        $this->instance->setOptions($options);

        $this->assertSame($options, $this->instance->getOptions());
    }

    public function testSingleOptionCanSetOverMethod()
    {
        $this->instance->setOptions(array(
            'foo' => 'bar',
            'baz' => array(
                'foobaz'
            )
        ));

        $this->instance->setOption('foo', 'baz');
        $this->instance->setOption('bar', 'baz');

        $newOptions = $this->instance->getOptions();
        $this->assertArraysAreSimilar($newOptions, array(
            'foo' => 'baz',
            'baz' => array(
                'foobaz'
            ),
            'bar' => 'baz'
        ));
    }

    public function testSingleArreOptionCanSetAndMergedOverMethod()
    {
        $this->instance->setOptions(array(
            'foo' => 'bar',
            'baz' => array(
                'foobaz' => 'fail'
            )
        ));
        $this->instance->setOption('baz', array('foo' => 'bar'));
        $this->instance->setOption('baz', array('foobaz' => 'foobar'));


        $newOptions = $this->instance->getOptions();
        $this->assertArraysAreSimilar($newOptions, array(
            'foo' => 'bar',
            'baz' => array(
                'foobaz' => 'foobar',
                'foo' => 'bar'
            )
        ));
    }

    public function testOptionCanReveivedOverMethod()
    {
        $options = array(
            'foo' => 'bar'
        );
        $this->instance->setOptions($options);

        $this->assertSame('bar', $this->instance->getOption('foo'));
    }

    public function testSingleTracking()
    {
        $instance = $this->instance;

        $trackingRequest = new TrackingRequest();
        $trackingRequest->setPayload(array('foo' => 'bar'));
        $trackingRequest->setResponseHeader(array('baz' => 'fooBar'));

        $collection = new TrackingRequestCollection();
        $collection->add($trackingRequest);

        $clientMock = $this->getClientMock();
        $clientMock->expects($this->once())
            ->method('send')
            ->will($this->returnValue($collection));

        $tracking = $this->getMock('Racecore\GATracking\Tracking\Event');
        $tracking->expects($this->once())
            ->method('getPackage')
            ->will($this->returnValue(array('test' => 'bar')));

        $instance->setClientAdapter($clientMock);
        $response = $instance->sendTracking($tracking);

        $responsePayload = $response->getPayload();
        $responseHeader = $response->getResponseHeader();

        $this->assertInstanceOf('Racecore\GATracking\Request\TrackingRequest', $response);
        $this->assertArrayHasKey('foo', $responsePayload);
        $this->assertSame('bar', $responsePayload['foo']);

        $this->assertArrayHasKey('baz', $responseHeader);
        $this->assertSame('fooBar', $responseHeader['baz']);
    }
}
