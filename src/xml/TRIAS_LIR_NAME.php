<?php

declare(strict_types=1);

namespace TriasClient\xml;

class TRIAS_LIR_NAME
{

    private string $requestorRef;
    private string $locationName;
    private int $numberOfResults;

    public function __construct(string $requestorRef, string $locationName, int $numberOfResults = 20)
    {
        $this->requestorRef = $requestorRef;
        $this->locationName = $locationName;
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
            <LocationInformationRequest>
                <InitialInput>
                    <LocationName>{$this->locationName}</LocationName>
                </InitialInput>
                <Restrictions>
                    <Type>stop</Type>
                    <NumberOfResults>{$this->numberOfResults}</NumberOfResults>
                </Restrictions>
            </LocationInformationRequest>
        </RequestPayload>
    </ServiceRequest>
</Trias>
EOT;
    }
}
