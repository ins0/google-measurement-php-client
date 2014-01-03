<?php
namespace Racecore\GATracking\Tracking;

/**
 * Class PageviewTest
 *
 * @author      Marco Rieger
 * @package       Racecore\GATracking\Tracking
 */
class PageviewTest extends \PHPUnit_Framework_TestCase {

    private $pageview;

    public function setUp()
    {
        $this->pageview  = new Pageview();
    }

    public function testPaketEqualsSpecification()
    {
        /** @var Pageview $pageview */
        $pageview = $this->pageview;
        $pageview->setDocumentPath('foo');
        $pageview->setDocumentTitle('bar');
        $pageview->setDocumentHost('baz');

        $packet = $pageview->getPaket();
        $this->assertSame(
            array(
                't'     =>  'pageview',
                'dh'    =>  'baz',
                'dp'    =>  'foo',
                'dt'    =>  'bar'
            ),
            $packet
        );
    }

    public function testGetterSetter()
    {
        /** @var Pageview $pageview */
        $pageview = $this->pageview;

        $pageview->setDocumentHost('foo');
        $this->assertEquals('foo', $pageview->getDocumentHost() );

        $pageview->setDocumentPath('bar');
        $this->assertEquals('bar', $pageview->getDocumentPath() );

        $pageview->setDocumentTitle('baz');
        $this->assertEquals('baz', $pageview->getDocumentTitle() );
    }

}
 