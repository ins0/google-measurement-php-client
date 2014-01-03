<?php
// autoloader
require_once( dirname(__FILE__) . '/../src/Racecore/GATracking/Autoloader.php');
Racecore\GATracking\Autoloader::register(dirname(__FILE__).'/../src/');

// init tracking
$tracking = new \Racecore\GATracking\GATracking();
$tracking->setAccountID('UA-XXXXXXXX-X');

// Campaign Tracking
$campain = new \Racecore\GATracking\Tracking\Campaign();
$campain->setDocumentPath('/test/path2');
$campain->setDocumentTitle('Test Title');
$campain->setCampaignName('Test Campaign Name');
$campain->setCampaignSource('Test Source');
$campain->setCampaignMedium('Test Medium');
$campain->setCampaignContent('Test Content');
$campain->setCampaignKeywords(array('test keyword'));

// add to stack
$tracking->addTracking($campain);

// Ecommerce Transaction Tracking
$transaction = new \Racecore\GATracking\Tracking\Ecommerce\Transaction();
$transaction->setID('1234');
$transaction->setAffiliation('Affiliation name');
$transaction->setRevenue(123.45);
$transaction->setShipping(12.34);
$transaction->setTax(12.34);
$transaction->setCurrency('EUR');
$transaction->setTransactionHost('www.domain.tld');

// add to stack
$tracking->addTracking($transaction);

// Ecommerce Item Tracking
$item = new \Racecore\GATracking\Tracking\Ecommerce\Item();
$item->setTransactionID('1234'); // the one used above
$item->setName('Product name');
$item->setPrice(123.45);
$item->setQuantity(1);
$item->setSku('product_sku');
$item->setCategory('Category');
$item->setCurrency('EUR');
$item->setTransactionHost('www.domain.tld');  // the one used above

// add to stack
$tracking->addTracking($item);

// Pageview Tacking
$pageview = new \Racecore\GATracking\Tracking\Pageview();
$pageview->setDocumentPath('/test/pageview/blub.jpg');
$pageview->setDocumentTitle('Test Image Title');

// add to stack
$tracking->addTracking($pageview);

// [...] more tracking

// Do the Job!
Try {
    $tracking->send();
    echo 'success';

} Catch (Exception $e) {

    echo 'Error: ' . $e->getMessage();
}

