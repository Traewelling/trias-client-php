<?php

namespace TriasClient\trias;

use TriasClient\RequestAndParse;
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

    public function getDepartures(DepartureRequestOptions $options)
    {
        $maxResults = isset($options->maxResults) ? $options->maxResults : 10;
        $time = isset($options->time) ? $options->time : new DateTime();
        $payload = new TRIAS_SER($this->requestorRef, $options->id, $time, $maxResults);

        $request = new RequestAndParse($this->url, $payload->getXML(), $this->headers);
        $result = $request->requestAndParse();
        var_dump($result);
        $result = $result
            ->triasServiceDelivery
            ->triasDeliveryPayload
            ->triasStopEventResponse
            ->triasStopEventResult;
        $departures = [];

        foreach ($result as $departure) {
            $stopId = $departure->triasStopPointRef->triasStopPointRef;
            $stopName = $departure->triasStopPointName->triasText;
            $stopLocation = new FPTFLocation(
                $departure->triasLocation->triasGeoPosition->triasLongitude,
                $departure->triasLocation->triasGeoPosition->triasLatitude,
                $departure->triasLocation->triasGeoPosition->triasAltitude,
                $departure->triasLocation->triasLocationName->triasText,
                $departure->triasLocation->triasStopPoint->triasStopPointName->triasText
            );
            $stop = new FPTFStop($stopId, $stopName, $stopLocation);
            $departureTime = $departure->triasService->triasOperatingDayRef . "T" . $departure->triasService->triasTimetabledTime;
            $departureTime = new \DateTime($departureTime);
            $departureTime = $departureTime->format("c");
            $departurePlatform = $departure->triasService->triasPlannedBay->triasText;
            $departurePlatform = $departurePlatform ? $departurePlatform : null;
            $departureDelay = $departure->triasService->triasEstimatedTime->triasTimeDeviation;
            $departureDelay = $departureDelay ? $departureDelay : null;
            $departureLine = $departure->triasService->triasPublishedLineName->triasText;
            $departureLine = $departureLine ? $departureLine : null;
        }
    }
}
