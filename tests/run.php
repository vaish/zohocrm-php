<?php

// Include bootstrap loader
require_once '/home/composer/public_html/zohocrm-php/vendor/autoload.php';

use Zoho\CRM\Client;

// Create the client
$zoho = new Client('03cad6645a64b845160448b5b2b793d7');

var_dump($zoho);
