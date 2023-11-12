<?php

namespace TriasClient\trias;

use TriasClient\RequestAndParse;
use TriasClient\types\FPTF\FPTFLine;
use TriasClient\types\FPTF\FPTFMode;
use TriasClient\types\FPTF\FPTFStopover;
use TriasClient\types\FPTF\FPTFSubmode;
use TriasClient\types\FPTF\Situation;
use TriasClient\types\options\DepartureRequestOptions;
use TriasClient\xml\TRIAS_SER;
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
     * @return FPTFStopover[]
     */
    public function getDepartures(DepartureRequestOptions $options)
    {
        $maxResults = isset($options->maxResults) ? $options->maxResults : 10;
        $time = isset($options->time) ? $options->time : new DateTime();
        $payload = new TRIAS_SER($this->requestorRef, $options->id, $time, $maxResults);

        $request = new RequestAndParse($this->url, $payload->getXML(), $this->headers);
        $result = $request->requestAndParse();
        $result = $result
            ->ServiceDelivery
            ->DeliveryPayload
            ->StopEventResponse;

        $departures = [];

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
            $stop = $departure->ThisCall->CallAtStop->StopPointRef ?? $options->id;

            $direction = $departure->Service->DestinationText->Text ?? '';
            $lineName = $departure->Service->ServiceSection->PublishedLineName->Text ?? '';
            $timetabledTime = $departure->ThisCall->CallAtStop->ServiceDeparture->TimetabledTime
                ?? null;
            $estimatedTime = $departure->ThisCall->CallAtStop->ServiceDeparture->EstimatedTime
                ?? null;
            $departureDelay = $estimatedTime ?round((strtotime($estimatedTime) - strtotime($timetabledTime)) / 60) : null;
            $plannedBay = $departure->ThisCall->CallAtStop->PlannedBay->Text ?? null;
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


            $departures[] = new FPTFStopover(
                stop: $stop,
                line: new FPTFLine($lineName, $lineName),
                mode: $type,
                subMode: $subtype ?? null,
                direction: $direction,
                arrival: null,
                arrivalDelay: null,
                arrivalPlatform: null,
                departure: $timetabledTime,
                departureDelay: $departureDelay,
                departurePlatform: $plannedBay
            );
        }

        return $departures;
    }
}
