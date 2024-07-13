<?php

declare(strict_types=1);

namespace TriasClient\xml;

class TRIAS_LocationInformationRequest_POS
{

    private string $requestorRef;
    private float $latitude;
    private float $longitude;
    private int $radius;
    private int $numberOfResults;

    public function __construct(
        string $requestorRef,
        float  $latitude,
        float  $longitude,
        int    $radius,
        int    $numberOfResults = 20
    )
    {
        $this->requestorRef = $requestorRef;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->radius = $radius;
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
                    <GeoRestriction>
                        <Circle>
                            <Center>
                                <Longitude>{$this->longitude}</Longitude>
                                <Latitude>{$this->latitude}</Latitude>
                            </Center>
                            <Radius>{$this->radius}</Radius>
                        </Circle>
                    </GeoRestriction>
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
