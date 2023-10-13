<?php

namespace TriasClient\types\FPTF;

class FPTFLocation
{
    public string $type;
    public ?string $name;
    public ?string $address;
    public ?float $longitude;
    public ?float $latitude;
    public ?float $altitude;

    public function __construct(
        ?float $longitude = null,
        ?float $latitude = null,
        ?float $altitude = null,
        ?string $name = null,
        ?string $address = null,
    ) {
        $this->type = "location";
        $this->name = $name;
        $this->address = $address;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->altitude = $altitude;
    }
}
