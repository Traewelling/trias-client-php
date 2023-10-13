<?php

declare(strict_types=1);

namespace TriasClient\trias;

use TriasClient\RequestAndParse;
use TriasClient\types\FPTF\FPTFLocation;
use TriasClient\types\FPTF\FPTFStop;
use TriasClient\types\options\StopsRequestOptions;
use TriasClient\xml\TRIAS_LIR_NAME;

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
            $payload = (new TRIAS_LIR_NAME($this->requestorRef, $options->name, $maxResults))->getXML();
        } elseif ($options->latitude !== null && $options->longitude !== null && $options->radius !== null) {
            $payload = (
                new TRIAS_LIR_POS(
                    $this->requestorRef,
                    $options->latitude,
                    $options->longitude,
                    $options->radius, $maxResults
                )
            )->getXML();
        } else {
            throw new \Exception("Invalid options");
        }

        $request  = new RequestAndParse($this->url, $payload, $this->headers);
        $result   = $request->requestAndParse();
        $result   = $result
            ->triasServiceDelivery
            ->triasDeliveryPayload
            ->triasLocationInformationResponse
            ->triasLocationResult;
        $stops    = [];

        foreach ($result as $stop) {
            $locationName = $stop->triasLocation->triasLocationName->triasText ?? null;
            $stationName = $stop->triasLocation->triasStopPoint->triasStopPointName->triasText ?? null;
            $location = null;

            if ($locationName && $stationName && !str_contains($locationName, $stationName)) {
                $stationName = $locationName . ' ' . $stationName;
            }

            if (
                isset($stop->triasLocation->triasGeoPosition->triasLatitude)
                && isset($stop->triasLocation->triasGeoPosition->triasLongitude)
            ) {
                $location = new FPTFLocation(
                    (float) $stop->triasLocation->triasGeoPosition->triasLongitude,
                    (float) $stop->triasLocation->triasGeoPosition->triasLatitude,
                    isset($stop->triasLocation->triasGeoPosition->triasAltitude)
                        ? (float) $stop->triasLocation->triasGeoPosition->triasAltitude
                        : null
                );
            }

            $stops [] = new FPTFStop(
                $stop->triasLocation->triasStopPoint->triasStopPointRef,
                $stationName ?? '',
                $location
            );
        }

        return $stops;
    }
}
