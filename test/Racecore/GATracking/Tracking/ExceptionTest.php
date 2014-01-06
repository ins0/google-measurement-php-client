<?php
namespace Racecore\GATracking\Tracking;

/**
 * Class ExceptionTest
 *
 * @author      Marco Rieger
 * @package       Racecore\GATracking\Tracking
 */
class ExceptionTest extends \PHPUnit_Framework_TestCase {

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

        $packet = $exception->getPaket();
        $this->assertSame(
            array(
                't'     =>  'exception',
                'exd'    =>  'Test Description',
                'exf'    =>  '1'
            ),
            $packet
        );
    }

    public function testGetterSetter()
    {
        /** @var Exception $exception */
        $exception = $this->exception;

        $exception->setExceptionDescription('Test Description');
        $this->assertEquals('Test Description', $exception->getExceptionDescription() );

        $exception->setExceptionFatal(true);
        $this->assertEquals('1', $exception->getExceptionFatal() );

    }

}
 