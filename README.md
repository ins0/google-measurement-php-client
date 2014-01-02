GATracking
==========

![Build Status](https://travis-ci.org/ins0/google-measurement-php-client.png?branch=master)

GATracking is a Server-Side PHP Client to communicate to Google Analytics over the Google Measurement Protocol API

https://developers.google.com/analytics/devguides/collection/protocol/v1/devguide

### Features

- Campaign Tracking
- Pageview Tracking
- Ecommerce Transaction Tracking
- Ecommerce Item Tracking

## Quick start

### Install via Composer
In the `require` key of `composer.json` file add the following

    "ins0/google-measurement-php-client": "dev-master"

Run the Composer update command

    $ composer update


#Requirements#

PHP >= 5.3.3

Google Analytics Universal Account (more information available here https://support.google.com/analytics/answer/2817075?hl=en)

#Example#

    // init tracking
    $tracking = new GATracking();
    $tracking->setAccountID('UA-XXXXXXXX-X');

    // Campaign Tracking
    $campain = new Campaign();
    $campain->setDocumentPath('/test/path2');
    $campain->setDocumentTitle('Test Title');
    $campain->setCampaignName('Test Campaign Name');
    $campain->setCampaignSource('Test Source');
    $campain->setCampaignMedium('Test Medium');
    $campain->setCampaignContent('Test Content');
    $campain->setCampaignKeywords(array('test keyword'));


    // Ecommerce Transaction Tracking
    $transaction = new Transaction();
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

    $item = new Item();
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

    // [...] more tracking
    // Pageview Tacking
    $pageview = new Pageview();
    $pageview->setDocumentPath('/test/pageview/blub.jpg');
    $pageview->setDocumentTitle('Test Image Title');

    // add to stack
    $tracking->addTracking($pageview);

    // Do the Job!
    Try {
        $tracking->send();
        echo 'success';

    } Catch (Exception $e) {

        echo 'Error: ' . $e->getMessage();
    }







Thanks
==========

first GIT release .... yaahhh!
