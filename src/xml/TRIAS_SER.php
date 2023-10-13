<?php

declare(strict_types=1);

namespace TriasClient\xml;

class TRIAS_SER
{

    private string $requestorRef;
    private string $locationReference;
    private int $numberOfResults;

    public function __construct(string $requestorRef, string $locationReference, int $numberOfResults = 20)
    {
        $this->requestorRef = $requestorRef;
        $this->locationReference = $locationReference;
        $this->numberOfResults = $numberOfResults;
    }

    public function getXML(): string
    {
        $xml = <<<EOT
<?xml version="1.0" encoding="UTF-8" ?>
<Trias version="1.2" xmlns="http://www.vdv.de/trias" xmlns:siri="http://www.siri.org.uk/siri" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="https://raw.githubusercontent.com/VDVde/TRIAS/v1.2/Trias.xsd">
    <ServiceRequest>
        <siri:RequestorRef>%1$s</siri:RequestorRef>
        <RequestPayload>
            <StopEventRequest>
                <Location>
                    <LocationRef>
                        <StopPointRef>%2$s</StopPointRef>
                    </LocationRef>
                    <DepArrTime>%3$s</DepArrTime>
                </Location>
                <Params>
                    <IncludeRealtimeData>true</IncludeRealtimeData>
                    <NumberOfResults>%4$s</NumberOfResults>
                    <StopEventType>departure</StopEventType>
                </Params>
            </StopEventRequest>
        </RequestPayload>
    </ServiceRequest>
</Trias>
EOT;

        return sprintf($xml, $this->requestorRef, $this->locationReference, $this->numberOfResults);
    }
}
