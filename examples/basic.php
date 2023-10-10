<?php

require_once __DIR__ . '/../vendor/autoload.php';

use \TriasClient\Client;
use \TriasClient\trias\TRIASStopsHandler;

$test = new TRIASStopsHandler(
    'https://api.opentransportdata.swiss/trias2020',
    'trias-client',
    ['authorization' => '57c5dbbbf1fe4d000100001842c323fa9ff44fbba0b9b925f0c052d1']
);

var_dump($test->getStops(
    (new \TriasClient\types\StopsRequestOptions())
        ->setName('Zürich HB')
        ->setMaxResults(5)
));
