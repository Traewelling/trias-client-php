<?php

namespace TriasClient\types\FPTF;

class FPTFStopover
{
    public string $type = 'stopover';
    public string $stop;
    public ?FPTFLine $line = null; // Not included in FPTF
    public FPTFMode $mode;
    public ?FPTFSubmode $subMode = null;
    public ?string $direction = null; // Not included in FPTF
    public ?string $arrival = null;
    public ?int $arrivalDelay = null;
    public ?string $arrivalPlatform = null;
    public ?string $departure = null;
    public ?int $departureDelay = null;
    public ?string $departurePlatform = null;

    /**
     * @param string $type
     * @param string $stop
     * @param FPTFLine|null $line
     * @param FPTFMode $mode
     * @param FPTFSubmode|null $subMode
     * @param string|null $direction
     * @param string|null $arrival
     * @param int|null $arrivalDelay
     * @param string|null $arrivalPlatform
     * @param string|null $departure
     * @param int|null $departureDelay
     * @param string|null $departurePlatform
     */
    public function __construct(
        string $stop,
        ?FPTFLine $line,
        FPTFMode $mode,
        ?FPTFSubmode $subMode,
        ?string $direction,
        ?string $arrival,
        ?int $arrivalDelay,
        ?string $arrivalPlatform,
        ?string $departure,
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
        $this->arrivalDelay = $arrivalDelay;
        $this->arrivalPlatform = $arrivalPlatform;
        $this->departure = $departure;
        $this->departureDelay = $departureDelay;
        $this->departurePlatform = $departurePlatform;
    }


}
