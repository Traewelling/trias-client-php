<?php

declare(strict_types=1);

namespace TriasClient\types\FPTF;

class FPTFStopover
{
    public string $type = 'stopover';
    public string|FPTFStop $stop;
    public ?FPTFLine $line = null; // Not included in FPTF
    public FPTFMode $mode;
    public ?FPTFSubmode $subMode = null;
    public ?string $direction = null; // Not included in FPTF
    public ?string $arrival = null;
    public ?string $plannedArrival = null;
    public ?int $arrivalDelay = null;
    public ?string $arrivalPlatform = null;
    public ?string $departure = null;
    public ?string $plannedDeparture = null;
    public ?int $departureDelay = null;
    public ?string $departurePlatform = null;

    /**
     * @param string|FPTFStop $stop
     * @param FPTFLine|null $line
     * @param FPTFMode $mode
     * @param FPTFSubmode|null $subMode
     * @param string|null $direction
     * @param string|null $arrival
     * @param string|null $plannedArrival
     * @param int|null $arrivalDelay
     * @param string|null $arrivalPlatform
     * @param string|null $departure
     * @param string|null $plannedDeparture
     * @param int|null $departureDelay
     * @param string|null $departurePlatform
     */
    public function __construct(
        string|FPTFStop $stop,
        ?FPTFLine $line,
        FPTFMode $mode,
        ?FPTFSubmode $subMode,
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
        $this->subMode = $subMode;
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
