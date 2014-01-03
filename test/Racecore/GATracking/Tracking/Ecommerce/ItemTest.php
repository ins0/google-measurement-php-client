<?php
namespace Racecore\GATracking\Tracking\Ecommerce;

/**
 * Class ItemTest
 *
 * @author      Enea Berti
 * @package     Racecore\GATracking\Tracking\Ecommerce
 */
class ItemTest extends \PHPUnit_Framework_TestCase {

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

        $packet = $item->getPaket();

        $this->assertSame(
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
 