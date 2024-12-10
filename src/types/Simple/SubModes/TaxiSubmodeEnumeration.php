<?php

declare(strict_types=1);

namespace TriasClient\types\Simple\SubModes;

enum TaxiSubmodeEnumeration: string {
    case UNKNOWN = 'unknown';
    case UNDEFINED = 'undefined';
    case COMMUNAL_TAXI = 'communalTaxi';
    case WATER_TAXI = 'waterTaxi';
    case RAIL_TAXI = 'railTaxi';
    case BIKE_TAXI = 'bikeTaxi';
    case BLACK_CAB = 'blackCab';
    case MINI_CAB = 'miniCab';
    case ALL_TAXI_SERVICES = 'allTaxiServices';
}
