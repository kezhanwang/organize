<?php

use Organize\Client;

$merchant = getenv('merchant');
$signature = getenv('signature');
$rsaPublicFile = getenv('reaPublicFile');

$data = array(
    'api' => getenv('api'),
    'version' => getenv('version'),
    'child_merchant' => getenv('child_merchant'),
);

$client = new Client($merchant, $signature, $data, $rsaPublicFile);