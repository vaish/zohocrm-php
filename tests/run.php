<?php

// Include bootstrap loader
require_once '/home/composer/public_html/zohocrm-php/vendor/autoload.php';

use Zoho\CRM\Client;

// Create the client
$zoho = new Client('ACCESS_TOKEN');

var_dump($zoho);
