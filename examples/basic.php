<?php

require_once __DIR__ . '/../vendor/autoload.php';

use TriasClient\trias\TRIASStopsHandler;

$test = new \TriasClient\trias\TRIASDeparturesHandler(
    'https://api.opentransportdata.swiss/trias2020',
    'trias-client',
    ['authorization' => '57c5dbbbf1fe4d000100001842c323fa9ff44fbba0b9b925f0c052d1']
);

$test = $test->getDepartures(
    (new \TriasClient\types\options\DepartureRequestOptions())
        ->setId('8505000')
        //->setTime('2023-10-13T21:35:00+01:00')
        ->setMaxResults(50)
);
//8503000

foreach ($test as $a) {
    print_r("\n=================================");
    print_r("\nLinie: " . $a->line->id);
    print_r("\nNach: " . $a->direction);
    print_r("\nAbfahrt: " . $a->departure . ($a->departureDelay && $a->departureDelay > 0
            ? ' (+' . $a->departureDelay . ')' : ''));
    print_r("\n=================================\n");
}
die();


$test = new TRIASStopsHandler(
    'https://api.opentransportdata.swiss/trias2020',
    'trias-client',
    ['authorization' => '57c5dbbbf1fe4d000100001842c323fa9ff44fbba0b9b925f0c052d1']
);


$a = $test->getStops(
    (new \TriasClient\types\options\StopsRequestOptions())
        ->setName('Luzern')
        ->setMaxResults(5)
);

foreach ($a as $b) {
    var_dump($b->name);
}
