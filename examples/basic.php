<?php

require_once __DIR__ . '/../vendor/autoload.php';

use TriasClient\trias\TRIASStopsHandler;

$test = new \TriasClient\trias\TRIASDeparturesHandler(
    'https://api.opentransportdata.swiss/trias2020',
    'trias-client',
    ['authorization' => '57c5dbbbf1fe4d000100001842c323fa9ff44fbba0b9b925f0c052d1']
);

$test->getDepartures(
    (new \TriasClient\types\options\DepartureRequestOptions())
        ->setId('8500010')
        ->setMaxResults(5)
);
//8503000
var_dump($test);
die();


$test = new TRIASStopsHandler(
    'https://api.opentransportdata.swiss/trias2020',
    'trias-client',
    ['authorization' => '57c5dbbbf1fe4d000100001842c323fa9ff44fbba0b9b925f0c052d1']
);


$a = $test->getStops(
    (new \TriasClient\types\options\StopsRequestOptions())
        ->setName('Basel')
        ->setMaxResults(5)
);

foreach ($a as $b) {
    var_dump($b->name);
}
