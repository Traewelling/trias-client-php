<?php

declare(strict_types=1);

namespace TriasClient\trias;

use TriasClient\types\StopsRequestOptions;
use TriasClient\xml\TRIAS_LIR_NAME;
use TriasClient\RequestAndParse;

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
            ))->getXML();
        } else {
            throw new \Exception("Invalid options");
        }

        $request = new RequestAndParse($this->url, $payload, $this->headers);
        return $request->requestAndParse();
    }
}
