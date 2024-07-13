<?php

declare(strict_types=1);

namespace TriasClient\trias;

use TriasClient\RequestAndParse;
use TriasClient\types\FPTF\FPTFLocation;
use TriasClient\types\FPTF\FPTFStop;
use TriasClient\types\options\StopsRequestOptions;
use TriasClient\xml\TRIAS_LocationInformationRequest_NAME;

class TRIASStopsHandler
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
     * @return FPTFLocation[]
     */
    public function getStops(StopsRequestOptions $options): array
    {
        $maxResults = $options ? $options->maxResults : 10;

        if (!empty($options->name)) {
            $payload = (new TRIAS_LocationInformationRequest_NAME($this->requestorRef, $options->name, $maxResults))->getXML();
        } elseif ($options->latitude !== null && $options->longitude !== null && $options->radius !== null) {
            $payload = (
                new TRIAS_LIR_POS(
                    $this->requestorRef,
                    $options->latitude,
                    $options->longitude,
                    $options->radius,
                    $maxResults
                )
            )->getXML();
        } else {
            throw new \Exception("Invalid options");
        }

        $request  = new RequestAndParse($this->url, $payload, $this->headers);
        $result   = $request->requestAndParse();
        $result   = $result
            ->ServiceDelivery
            ->DeliveryPayload
            ->LocationInformationResponse
            ->LocationResult;
        $stops    = [];

        if (!is_array($result)) {
            $result = [$result];
        }

        foreach ($result as $stop) {
            $locationName = $stop->Location->LocationName->Text ?? null;
            $stationName = $stop->Location->StopPoint->StopPointName->Text ?? null;
            $location = null;

            if ($locationName && $stationName && !str_contains($locationName, $stationName)) {
                $stationName = $locationName . ' ' . $stationName;
            }

            if (isset($stop->Location->GeoPosition->Latitude) && isset($stop->Location->GeoPosition->Longitude)) {
                $location = new FPTFLocation(
                    (float) $stop->Location->GeoPosition->Longitude,
                    (float) $stop->Location->GeoPosition->Latitude,
                    isset($stop->Location->GeoPosition->Altitude)
                        ? (float) $stop->Location->GeoPosition->Altitude
                        : null
                );
            }
            if (isset($stop->Location->GeoPosition->Latitude) && isset($stop->Location->GeoPosition->Longitude)) {
                $location = new FPTFLocation(
                    (float) $stop->Location->GeoPosition->Longitude,
                    (float) $stop->Location->GeoPosition->Latitude,
                    isset($stop->Location->GeoPosition->Altitude)
                        ? (float) $stop->Location->GeoPosition->Altitude
                        : null
                );
            }

            $stops [] = new FPTFStop(
                $stop->Location->StopPoint->StopPointRef,
                $stationName ?? '',
                $location
            );
        }

        return $stops;
    }
}
