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
        $this->assertArraysAreSimilar(
            array(
                't'     =>  'pageview',
                'dh'    =>  'baz',
                'dp'    =>  'foo',
                'dt'    =>  'bar'
            ),
            $packet
        );
    }
}
