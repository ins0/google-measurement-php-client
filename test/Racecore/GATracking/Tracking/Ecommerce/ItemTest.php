<?php
namespace Racecore\GATracking\Tracking\Ecommerce;
use Racecore\GATracking\AbstractGATrackingTest;

/**
 * Class ItemTest
 *
 * @author      Enea Berti
 * @package     Racecore\GATracking\Tracking\Ecommerce
 */
class ItemTest extends AbstractGATrackingTest {

    /**
     * @var Campaign
     */
    private $item;

    public function setUp()
    {
        $this->item  = new Item();
    }

    public function testPaketEqualsSpecification()
    {
        $item = $this->item;

        $item->setTransactionID('1234');
        $item->setName('Product name');
        $item->setPrice(123.45);
        $item->setQuantity(1);
        $item->setSku('product_sku');
        $item->setCategory('Category');
        $item->setCurrency('EUR');
        $item->setTransactionHost('www.domain.tld');

        $packet = $item->getPackage();

        $this->assertArraySimilar(
            array(
                't' => 'item',
                'ti' => '1234',
                'in' => 'Product name',
                'ip' => 123.45,
                'iq' => 1,
                'ic' => 'product_sku',
                'iv' => 'Category',
                'dh' => 'www.domain.tld',
                'cu' => 'EUR'
            ),
            $packet
        );
    }

}
 