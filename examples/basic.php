<?php

require_once __DIR__ . '/../vendor/autoload.php';

use TriasClient\trias\TRIASStopsHandler;

const URL = 'https://api.opentransportdata.swiss/trias2020';
const REQUESTOR_REF = 'trias-client';
const HEADERS = ['authorization' => '57c5dbbbf1fe4d000100001842c323fa9ff44fbba0b9b925f0c052d1'];

//testStopHandler();
testDeparturesHandler();

 function testStopHandler($request = 'Karlsruhe Hbf')
 {
     $test = new TRIASStopsHandler(URL, REQUESTOR_REF, HEADERS);

     $a = $test->getStops(
         (new \TriasClient\types\options\StopsRequestOptions())
             ->setName($request)
             ->setMaxResults(20)
     );


     print_r("\n=================================");
     print_r("\nSearch for: {$request}");
     print_r("\n=================================");

     foreach ($a as $b) {
         print_r("\n=================================");
         print_r("\n{$b->name} ({$b->id})");
     }
     print_r("\n=================================");
 }

function testDeparturesHandler()
{
    $test = new \TriasClient\trias\TRIASDeparturesHandler(
        URL,
        REQUESTOR_REF,
        HEADERS
    );

    $test = $test->getDepartures(
        (new \TriasClient\types\options\DepartureRequestOptions())
            ->setId('de:08212:90')
            //->setTime('2023-11-12T22:35:00+01:00')
            ->setMaxResults(50)
    );
//8503000
    print_r("\n=================================");
    print_r("\nLinerun for {$test->trips[0]->line->line} ({$test->trips[0]->line->id})");

    foreach ($test->trips[0]->stopovers as $stopover) {
        print_r("\n=================================");
        print_r("\n{$stopover->stop->name} ({$stopover->stop->id})");
        print_r("\nArr: {$stopover->arrival} ({$stopover->arrivalDelay})");
        print_r("\nDep: {$stopover->departure} ({$stopover->departureDelay})");
        print_r("\nPlatform: {$stopover->departurePlatform}");
    }

    foreach ($test->departures as $a) {
        print_r("\n=================================");
        print_r("\nLinie: " . $a->line->id);
        print_r("\nCategory: " . $a->mode->mode?->name);
        print_r("\nSubcategory: " . $a->mode->submode?->name);
        print_r("\nNach: " . $a->direction);
        print_r("\nAbfahrt: " . $a->departure . ($a->departureDelay && $a->departureDelay > 0
                ? ' (+' . $a->departureDelay . ')' : ''));
        print_r("\n=================================\n");
    }
}
