<?php

declare(strict_types=1);

namespace TriasClient\types\FPTF;

class FPTFTrip
{
    public string $id;
    public string $direction;
    public ?FPTFLine $line = null;
    public FPTFStop|string $origin;
    public ?string $departure;
    public ?string $plannedDeparture;
    public ?int $departureDelay = null;
    public ?string $departurePlatform = null;
    public ?string $plannedDeparturePlatform = null;
    public FPTFStop|string $destination;
    public ?string $arrival;
    public ?string $plannedArrival;
    public ?int $arrivalDelay = null;
    public ?string $arrivalPlatform = null;
    public ?string $plannedArrivalPlatform = null;
    /**
     * @var FPTFStopover[]
     */
    public array $stopovers = [];

    /**
     * @param string $id
     * @param string $direction
     * @param FPTFLine|null $line
     * @param FPTFStop|string $origin
     * @param string|null $departure
     * @param string|null $plannedDeparture
     * @param int|null $departureDelay
     * @param string|null $departurePlatform
     * @param string|null $plannedDeparturePlatform
     * @param FPTFStop|string $destination
     * @param string|null $arrival
     * @param string|null $plannedArrival
     * @param int|null $arrivalDelay
     * @param string|null $arrivalPlatform
     * @param string|null $plannedArrivalPlatform
     * @param FPTFStopover[] $stopovers
     */
    public function __construct(
        string          $id,
        string          $direction,
        ?FPTFLine       $line,
        FPTFStop|string $origin,
        ?string         $departure,
        ?string         $plannedDeparture,
        ?int            $departureDelay,
        ?string         $departurePlatform,
        ?string         $plannedDeparturePlatform,
        FPTFStop|string $destination,
        ?string         $arrival,
        ?string         $plannedArrival,
        ?int            $arrivalDelay,
        ?string         $arrivalPlatform,
        ?string         $plannedArrivalPlatform,
        array           $stopovers
    )
    {
        $this->id = $id;
        $this->direction = $direction;
        $this->line = $line;
        $this->origin = $origin;
        $this->departure = $departure;
        $this->plannedDeparture = $plannedDeparture;
        $this->departureDelay = $departureDelay;
        $this->departurePlatform = $departurePlatform;
        $this->plannedDeparturePlatform = $plannedDeparturePlatform;
        $this->destination = $destination;
        $this->arrival = $arrival;
        $this->plannedArrival = $plannedArrival;
        $this->arrivalDelay = $arrivalDelay;
        $this->arrivalPlatform = $arrivalPlatform;
        $this->plannedArrivalPlatform = $plannedArrivalPlatform;
        $this->stopovers = $stopovers;
    }
}
