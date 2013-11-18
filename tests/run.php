<?php

// Include bootstrap loader
require_once '/home/composer/public_html/zohocrm-php/vendor/autoload.php';

use Zoho\CRM\Client;
use Zoho\CRM\Entities\Lead;

// Create the client
$zoho = new Client('ACCESS_TOKEN');
$lead = new Lead();

var_dump($lead);
