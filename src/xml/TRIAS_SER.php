<?php

declare(strict_types=1);

namespace TriasClient\xml;

use Cassandra\Date;
use \DateTime;

class TRIAS_SER
{

    private string $requestorRef;
    private string $locationReference;
    private string $departureTime;
    private int $numberOfResults;

    public function __construct(
        string $requestorRef,
        string $locationReference,
        DateTime $departureTime,
        int $numberOfResults = 20
    ) {
        $this->requestorRef = $requestorRef;
        $this->locationReference = $locationReference;
        $this->departureTime = $departureTime->setTimezone(new \DateTimeZone('Europe/Berlin'))->format("Y-m-d\TH:i:s");
        $this->numberOfResults = $numberOfResults;
    }

    public function getXML(): string
    {
        return <<<EOT
<?xml version="1.0" encoding="UTF-8" ?>
<Trias version="1.2" xmlns="http://www.vdv.de/trias" xmlns:siri="http://www.siri.org.uk/siri" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="https://raw.githubusercontent.com/VDVde/TRIAS/v1.2/Trias.xsd">
    <ServiceRequest>
        <siri:RequestorRef>{$this->requestorRef}</siri:RequestorRef>
        <RequestPayload>
            <StopEventRequest>
                <Location>
                    <LocationRef>
                        <StopPointRef>{$this->locationReference}</StopPointRef>
                    </LocationRef>
                    <DepArrTime>{$this->departureTime}</DepArrTime>
                </Location>
                <Params>
                    <IncludeRealtimeData>true</IncludeRealtimeData>
                    <IncludePreviousCalls>true</IncludePreviousCalls>
                    <IncludeOnwardCalls>true</IncludeOnwardCalls>
                    <NumberOfResults>{$this->numberOfResults}</NumberOfResults>
                    <StopEventType>departure</StopEventType>
                </Params>
            </StopEventRequest>
        </RequestPayload>
    </ServiceRequest>
</Trias>
EOT;
    }
}
