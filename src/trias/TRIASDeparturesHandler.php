<?php

declare(strict_types=1);

namespace TriasClient\trias;

use TriasClient\RequestAndParse;
use TriasClient\trias\Service\TypeService;
use TriasClient\types\FPTF\FPTFLine;
use TriasClient\types\FPTF\FPTFStop;
use TriasClient\types\FPTF\FPTFStopover;
use TriasClient\types\FPTF\FPTFTrip;
use TriasClient\types\FriendlyTrias\ModeDto;
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

            $removeModeName = $departure->Service->ServiceSection->Mode->Name->Text;

            $lineId = $departure->Service->ServiceSection->LineRef ?? '';
            $lineName = $departure->Service->ServiceSection->PublishedLineName->Text ?? '';
            $shortLineName = trim(str_replace($removeModeName, '', $lineName));

            $dto = (new TypeService())->getMode($departure->Service->ServiceSection->Mode);

            $call = $departure->ThisCall->CallAtStop;
            $departures[] = $this->createStopover($call, $options->id, $lineId, $lineName, $shortLineName, $dto, $direction);
            $trips[] = $this->createTrip($departure, $options->id, $lineId, $lineName, $shortLineName, $dto, $direction);
        }
        $response->departures = $departures;
        $response->trips = $trips;

        return $response;
    }

    public function createTrip(
        $departure,
        string $fallbackStopId,
        string $lineId,
        string $lineName,
        string $shortName,
        ?ModeDto $mode,
        string $direction
    ): FPTFTrip
    {
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
                $lineId,
                $lineName,
                $shortName,
                $mode,
                $direction
            );
        }

        return new FPTFTrip(
            id: $departure->Service->OperatingDayRef . "|" . $departure->Service->JourneyRef,
            direction: $direction,
            line: new FPTFLine($lineId, $lineName, $shortName),
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

    public function createStopover(
        $call,
        string $fallbackStopId,
        string $lineId,
        string $lineName,
        string $shortName,
        ?ModeDto $mode,
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
            (int)round((strtotime($estimatedDeparture) - strtotime($timetabledDeparture)) / 60)
            : null;
        $timetabledArrival = $call->ServiceArrival->TimetabledTime ?? null;
        $estimatedArrival = $call->ServiceArrival->EstimatedTime ?? $timetabledArrival;
        $arrivalDelay = $estimatedArrival && $timetabledArrival ?
            (int)round((strtotime($estimatedArrival) - strtotime($timetabledArrival)) / 60)
            : null;

        $plannedBay = $call->PlannedBay->Text ?? null;


        return new FPTFStopover(
            stop: $stop,
            line: new FPTFLine($lineId, $lineName, $shortName),
            mode: $mode,
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
