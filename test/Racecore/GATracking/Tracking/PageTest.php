<?php

namespace Racecore\GATracking\Tracking;

use Racecore\GATracking\AbstractGATrackingTest;

/**
 * Class PageviewTest
 *
 * @author      Marco Rieger
 * @package       Racecore\GATracking\Tracking
 */
class PageTest extends AbstractGATrackingTest
{
    private $page;

    public function setUp()
    {
        $this->page  = new Page();
    }

    public function testPaketEqualsSpecification()
    {
        /** @var Page $page */
        $page = $this->page;
        $page->setDocumentPath('foo');
        $page->setDocumentTitle('bar');
        $page->setDocumentHost('baz');

        $packet = $page->getPackage();
        $this->assertArraySimilar(
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
        /** @var Page $page */
        $page = $this->page;

        $page->setDocumentHost('foo');
        $this->assertEquals('foo', $page->getDocumentHost());

        $page->setDocumentPath('bar');
        $this->assertEquals('bar', $page->getDocumentPath());

        $page->setDocumentTitle('baz');
        $this->assertEquals('baz', $page->getDocumentTitle());
    }

}
