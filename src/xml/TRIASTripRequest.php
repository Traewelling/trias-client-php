<?php

declare(strict_types=1);

namespace TriasClient\xml;

class TRIASTripRequest
{

    private string $requestorRef;
    private int $numberOfResults;
    private string $origin;
    private string $departure;
    private string $via;
    private string $destination;
    private string $arrival;
    private bool $includeFares;

    public function __construct(
        string $requestorRef,
        int $numberOfResults,
        string $origin,
        string $departure,
        string $via,
        string $destination,
        string $arrival,
        bool $includeFares = false
    )
    {
        $this->requestorRef = $requestorRef;
        $this->numberOfResults = $numberOfResults;
        $this->origin = $origin;
        $this->departure = $departure;
        $this->via = $via;
        $this->destination = $destination;
        $this->arrival = $arrival;
        $this->includeFares = $includeFares;
    }


    public function getXML(): string
    {
        $xml = <<<EOT
<?xml version="1.0" encoding="UTF-8" ?>
<Trias version="1.2" xmlns="http://www.vdv.de/trias" xmlns:siri="http://www.siri.org.uk/siri" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="https://raw.githubusercontent.com/VDVde/TRIAS/v1.2/Trias.xsd">
    <ServiceRequest>
        <siri:RequestorRef>%1$s</siri:RequestorRef>
        <RequestPayload>
            <TripRequest>
                <Origin>
                    <LocationRef>
                        <StopPointRef>%2$s</StopPointRef>
                    </LocationRef>
                    %3$s
                </Origin>
                %3$s
                <Destination>
                    <LocationRef>
                        <StopPointRef>%4$s</StopPointRef>
                    </LocationRef>
                    %5$s
                </Destination>
                <Params>
                    <IncludeTurnDescription>false</IncludeTurnDescription>
                    <IncludeTrackSections>false</IncludeTrackSections>
                    <IncludeLegProjection>false</IncludeLegProjection>
                    <IncludeIntermediateStops>false</IncludeIntermediateStops>
                    <IncludeFares>%6$s</IncludeFares>
                    <NumberOfResults>%7$s</NumberOfResults>
                </Params>
            </TripRequest>
        </RequestPayload>
    </ServiceRequest>
</Trias>
EOT;

        return sprintf(
            $xml,
            $this->requestorRef,
            $this->origin,
            $this->departure,
            $this->via,
            $this->destination,
            $this->destination,
            $this->arrival,
            $this->includeFares,
            $this->numberOfResults
        );
    }
}
