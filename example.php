<?php
namespace GATracking;

use GATracking\Tracking\CampaignTracking;
use GATracking\Tracking\PageviewTracking;

require_once 'GATracking/GAautoloader.php';

// init tracking
$tracking = new GATracking();
$tracking->setAccountID('UA-42295470-1');

// Campaign Tracking
$campain = new CampaignTracking();
$campain->setDocumentPath('/test/path2');
$campain->setDocumentTitle('Test Title');
$campain->setCampaignName('Test Campaign Name');
$campain->setCampaignSource('Test Source');
$campain->setCampaignMedium('Test Medium');
$campain->setCampaignContent('Test Content');
$campain->setCampaignKeywords(array('test keyword'));

// add to stack
$tracking->addTracking($campain);

// Pageview Tacking
$pageview = new PageviewTracking();
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
