<?php

namespace Racecore\GATracking\Tracking;

use Racecore\GATracking\AbstractGATrackingTest;

/**
 * Class ExceptionTest
 *
 * @author      Marco Rieger
 * @package       Racecore\GATracking\Tracking
 */
class ExceptionTest extends AbstractGATrackingTest
{
    private $exception;

    public function setUp()
    {
        $this->exception  = new Exception();
    }

    public function testPaketEqualsSpecification()
    {
        /** @var Exception $exception */
        $exception = $this->exception;
        $exception->setExceptionDescription('Test Description');
        $exception->setExceptionFatal(true);

        $packet = $exception->getPackage();
        $this->assertArraysAreSimilar(
            array(
                't'     =>  'exception',
                'exd'    =>  'Test Description',
                'exf'    =>  '1'
            ),
            $packet
        );
    }
}
