<?php

declare(strict_types=1);

namespace TriasClient\trias;

use TriasClient\RequestAndParse;
use TriasClient\types\FPTF\FPTFLine;
use TriasClient\types\FPTF\FPTFMode;
use TriasClient\types\FPTF\FPTFStop;
use TriasClient\types\FPTF\FPTFStopover;
use TriasClient\types\FPTF\FPTFSubmode;
use TriasClient\types\FPTF\FPTFTrip;
use TriasClient\types\FPTF\Situation;
use TriasClient\types\options\DepartureRequestOptions;
use TriasClient\xml\TRIASStopEventRequest;
use \DateTime;

class TRIASDeparturesHandler
{
    private string $url;
    private string $requestorRef;
    private array $headers;

    public function __construct(string $url, string $requestorRef, ?array $headers = [])
    {
        $this->url = $url;
        $this->requestorRef = $requestorRef;
        $this->headers = $headers;
    }

    /**
     * @return \stdClass
     */
    public function getDepartures(DepartureRequestOptions $options)
    {
        $maxResults = isset($options->maxResults) ? $options->maxResults : 10;
        $time = isset($options->time) ? $options->time : new DateTime();
        $payload = new TRIASStopEventRequest($this->requestorRef, $options->id, $time, $maxResults);

        $request = new RequestAndParse($this->url, $payload->getXML(), $this->headers);
        $result = $request->requestAndParse();
        $result = $result
            ->ServiceDelivery
            ->DeliveryPayload
            ->StopEventResponse;

        $response = new \stdClass();
        $departures = [];
        $trips = [];

        if ($options->includeSituations) {
            /*
            $situationsResult = $result->StopEventResponseContext->Situations->PtSituation;
            foreach ($situationsResult as $situation) {
                $situations[] = new Situation(
                    title: isset($situation->siriSummary) ? $situation->siriSummary : '',
                    description: isset($situation->siriDetail) ? $situation->siriDetail : '',
                    validFrom: isset($situation->validityPeriod->StartTime) ? $situation->validityPeriod->StartTime : '',
                    validTo: isset($situation->validityPeriod->EndTime) ? $situation->validityPeriod->EndTime : '',
                    priority: isset($situation->Priority) ? $situation->Priority : ''
                );
            }*/
        }

        foreach ($result->StopEventResult as $departure) {
            $departure = $departure->StopEvent;
            $direction = $departure->Service->DestinationText->Text ?? '';
            $lineName = $departure->Service->ServiceSection->PublishedLineName->Text ?? '';
            $type = $departure->Service->ServiceSection->Mode->PtMode;

            if ($type === 'bus') {
                $type = FPTFMode::BUS;
            } elseif ($type === 'tram') {
                $type = FPTFMode::TRAIN;
                $subtype = FPTFSubmode::TRAM;
            } elseif ($type === 'metro') {
                $type = FPTFMode::TRAIN;
                $subtype = FPTFSubmode::METRO;
            } elseif ($type === 'rail') {
                $type = FPTFMode::TRAIN;
                $subtype = FPTFSubmode::RAIL;
            }


            $call = $departure->ThisCall->CallAtStop;
            $departures[] = $this->createStopover($call, $options->id, $lineName, $type, $subtype, $direction);
            $trips[] = $this->createTrip($departure, $options->id, $lineName, $type, $subtype, $direction);
        }
        $response->departures = $departures;
        $response->trips = $trips;

        return $response;
    }

    public function createTrip(
        $departure,
        string $fallbackStopId,
        string $lineName,
        ?FPTFMode $type,
        ?FPTFSubmode $subtype,
        string $direction
    ): FPTFTrip {
        $stops = [];
        if (isset($departure->PreviousCall)) {
            $stops = (is_array($departure->PreviousCall) ? $departure->PreviousCall : [$departure->PreviousCall]);
        }
        $stops = array_merge($stops, [$departure->ThisCall]);
        if (isset($departure->OnwardCall)) {
            $stops = array_merge(
                $stops,
                (is_array($departure->OnwardCall) ? $departure->OnwardCall : [$departure->OnwardCall])
            );
        }

        usort($stops, function ($a, $b) {
            return ($a->CallAtStop->StopSeqNumber < $b->CallAtStop->StopSeqNumber) ? -1 : 1;
        });

        /**
         * @var FPTFStopover[] $stopovers
         */
        $stopovers = [];
        foreach ($stops as $stop) {
            $stopovers[] = $this->createStopover(
                $stop->CallAtStop,
                $fallbackStopId,
                $lineName,
                $type,
                $subtype,
                $direction
            );
        }

        return new FPTFTrip(
            id: $departure->Service->OperatingDayRef . "|" .$departure->Service->JourneyRef,
            direction: $direction,
            line: new FPTFLine($lineName, $lineName),
            origin: $stopovers[0]->stop,
            departure: $stopovers[0]->departure,
            plannedDeparture: $stopovers[0]->plannedDeparture,
            departureDelay: $stopovers[0]->departureDelay,
            departurePlatform: $stopovers[0]->departurePlatform,
            plannedDeparturePlatform: $stopovers[0]->departurePlatform,
            destination: $stopovers[count($stopovers) - 1]->stop,
            arrival: $stopovers[count($stopovers) - 1]->arrival,
            plannedArrival: $stopovers[count($stopovers) - 1]->plannedArrival,
            arrivalDelay: $stopovers[count($stopovers) - 1]->arrivalDelay,
            arrivalPlatform: $stopovers[count($stopovers) - 1]->arrivalPlatform,
            plannedArrivalPlatform: $stopovers[count($stopovers) - 1]->arrivalPlatform,
            stopovers: $stopovers
        );
    }


    /**
     * @param $call
     * @param string $fallbackStopId
     * @param string $lineName
     * @param FPTFMode $type
     * @param FPTFSubmode $subtype
     * @param string $direction
     * @return FPTFStopover
     */
    public function createStopover(
        $call,
        string $fallbackStopId,
        string $lineName,
        ?FPTFMode $type,
        ?FPTFSubmode $subtype,
        string $direction
    ): FPTFStopover
    {
        $stop = !is_object($call->StopPointRef) && isset($call->StopPointRef) ? $call->StopPointRef : $fallbackStopId;
        if (isset($call->StopPointName->Text)) {
            $stop = new FPTFStop($stop, $call->StopPointName->Text);
        }

        $timetabledDeparture = $call->ServiceDeparture->TimetabledTime ?? null;
        $estimatedDeparture = $call->ServiceDeparture->EstimatedTime ?? $timetabledDeparture;
        $departureDelay = $estimatedDeparture && $timetabledDeparture ?
            (int) round((strtotime($estimatedDeparture) - strtotime($timetabledDeparture)) / 60)
            : null;
        $timetabledArrival = $call->ServiceArrival->TimetabledTime ?? null;
        $estimatedArrival = $call->ServiceArrival->EstimatedTime ?? $timetabledArrival;
        $arrivalDelay = $estimatedArrival && $timetabledArrival?
            (int) round((strtotime($estimatedArrival) - strtotime($timetabledArrival)) / 60)
            : null;

        $plannedBay = $call->PlannedBay->Text ?? null;


        return new FPTFStopover(
            stop: $stop,
            line: new FPTFLine($lineName, $lineName),
            mode: $type,
            subMode: $subtype ?? null,
            direction: $direction,
            arrival: $estimatedArrival,
            plannedArrival: $timetabledArrival,
            arrivalDelay: $arrivalDelay,
            arrivalPlatform: $plannedBay,
            departure: $estimatedDeparture,
            plannedDeparture: $timetabledDeparture,
            departureDelay: $departureDelay,
            departurePlatform: $plannedBay
        );
    }
}
