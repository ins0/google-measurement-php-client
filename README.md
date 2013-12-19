GATracking
==========

![Build Status](https://travis-ci.org/ins0/google-measurement-php-client.png?branch=master)

GATracking is a Server-Side PHP Client to communicate to Google Analytics over the Google Measurement Protocol API

https://developers.google.com/analytics/devguides/collection/protocol/v1/devguide

### Features

- Campaign Tracking
- Pageview Tracking

## Quick start

### Install via Composer
In the `require` key of `composer.json` file add the following

    "ins0/google-measurement-php-client": "dev-master"

Run the Composer update comand

    $ composer update


#Requirements#

PHP >= 5.3.3

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

    // add to stack
    $tracking->addTracking($campain);

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
