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
     * @var Campaign
     */
    private $campaign;

    public function setUp()
    {
        $this->campaign  = new Campaign();
    }

    public function testPaketEqualsSpecification()
    {
        $campaign = $this->campaign;

        $campaign->setDocumentTitle('Foo Bar Baz');
        $campaign->setDocumentPath('/foo/');
        $campaign->setDocumentHost('hostserver.name');

        $campaign->setCampaignID('123456');
        $campaign->setCampaignName('Foo Bar');
        $campaign->setCampaignContent('lorem ipsum');
        $campaign->setCampaignKeywords(array('keyword1','keyword2'));
        $campaign->setCampaignMedium('Foo Medium');
        $campaign->setCampaignSource('Bar Source');

        $packet = $campaign->getPaket();
        $this->assertSame(
            array(
                't' => 'pageview',
                'dh' => 'hostserver.name',
                'dp' => '/foo/',
                'dt' => 'Foo Bar Baz',
                'cn' => 'Foo Bar',
                'cs' => 'Bar Source',
                'cm' => 'Foo Medium',
                'ck' => 'keyword1;keyword2',
                'cc' => 'lorem ipsum',
                'ci' => '123456'
            ),
            $packet
        );
    }

    public function _testGetterSetter()
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
 