<?php

declare(strict_types=1);

namespace TriasClient\types\FPTF;

use TriasClient\types\FriendlyTrias\ModeDto;

class FPTFStopover
{
    public string $type = 'stopover';
    public string|FPTFStop $stop;
    public ?FPTFLine $line = null; // Not included in FPTF
    public ModeDto $mode;
    public ?string $direction = null; // Not included in FPTF
    public ?string $arrival = null;
    public ?string $plannedArrival = null;
    public ?int $arrivalDelay = null;
    public ?string $arrivalPlatform = null;
    public ?string $departure = null;
    public ?string $plannedDeparture = null;
    public ?int $departureDelay = null;
    public ?string $departurePlatform = null;

    public function __construct(
        string|FPTFStop $stop,
        ?FPTFLine $line,
        ModeDto $mode,
        ?string $direction,
        ?string $arrival,
        ?string $plannedArrival,
        ?int $arrivalDelay,
        ?string $arrivalPlatform,
        ?string $departure,
        ?string $plannedDeparture,
        ?int $departureDelay,
        ?string $departurePlatform
    )
    {
        $this->stop = $stop;
        $this->line = $line;
        $this->mode = $mode;
        $this->direction = $direction;
        $this->arrival = $arrival;
        $this->plannedArrival = $plannedArrival;
        $this->arrivalDelay = $arrivalDelay;
        $this->arrivalPlatform = $arrivalPlatform;
        $this->departure = $departure;
        $this->plannedDeparture = $plannedDeparture;
        $this->departureDelay = $departureDelay;
        $this->departurePlatform = $departurePlatform;
    }
}
