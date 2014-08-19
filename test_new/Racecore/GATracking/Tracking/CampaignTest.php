<?php
namespace Racecore\GATracking\Tracking;

/**
 * Class CampaignTest
 *
 * @author      Marco Rieger
 * @package       Racecore\GATracking\Tracking
 */
class CampaignTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Page
     */
    private $page;

    public function setUp()
    {
        $this->page  = new Page();
    }

    public function testPaketEqualsSpecification()
    {
        $page = $this->page;

        $page->setDocumentTitle('Foo Bar Baz');
        $page->setDocumentPath('/foo/');
        $page->setDocumentHost('hostserver.name');

        $page->setCampaignID('123456');
        $page->setCampaignName('Foo Bar');
        $page->setCampaignContent('lorem ipsum');
        $page->setCampaignKeyword('keyword1');
        $page->setCampaignMedium('Foo Medium');
        $page->setCampaignSource('Bar Source');

        $packet = $page->getPackage();
        $this->assertSame(
            array(
                't' => 'pageview',
                'cn' => 'Foo Bar',
                'cs' => 'Bar Source',
                'cm' => 'Foo Medium',
                'ck' => 'keyword1',
                'cc' => 'lorem ipsum',
                'ci' => '123456',
                'dh' => 'hostserver.name',
                'dp' => '/foo/',
                'dt' => 'Foo Bar Baz',
            ),
            $packet
        );
    }

}
 