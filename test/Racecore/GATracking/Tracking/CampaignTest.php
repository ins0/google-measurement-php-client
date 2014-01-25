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
    private $campaign;

    public function setUp()
    {
        $this->campaign  = new Page();
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
        $campaign->setCampaignKeyword('keyword1');
        $campaign->setCampaignMedium('Foo Medium');
        $campaign->setCampaignSource('Bar Source');

        $packet = $campaign->getPackage();
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
 