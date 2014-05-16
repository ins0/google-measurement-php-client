<?php
namespace Racecore\GATracking\Tracking\Ecommerce;

/**
 * Class TransactionTest
 *
 * @author      Enea Berti
 * @package     Racecore\GATracking\Tracking\Ecommerce
 */
class TransactionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Campaign
     */
    private $transaction;

    public function setUp()
    {
        $this->transaction  = new Transaction();
    }

    public function testPaketEqualsSpecification()
    {
        $transaction = $this->transaction;

        $transaction->setID('1234');
        $transaction->setAffiliation('Affiliation name');
        $transaction->setRevenue(123.45);
        $transaction->setShipping(12.34);
        $transaction->setTax(12.34);
        $transaction->setCurrency('EUR');
        $transaction->setTransactionHost('www.domain.tld');

        $packet = $transaction->getPaket();

        $this->assertSame(
            array(
                't' => 'transaction',
                'ti' => '1234',
                'ta' => 'Affiliation name',
                'tr' => 123.45,
                'ts' => 12.34,
                'tt' => 12.34,
                'dh' => 'www.domain.tld',
                'cu' => 'EUR'
            ),
            $packet
        );
    }

}
 