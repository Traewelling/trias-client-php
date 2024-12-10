<?php

namespace TriasClient\types\Simple\SubModes;

enum RailSubmodeEnumeration: string {
    case UNKNOWN = 'unknown';
    case UNDEFINED = 'undefined';
    case LOCAL = 'local';
    case HIGH_SPEED_RAIL = 'highSpeedRail';
    case SUBURBAN_RAILWAY = 'suburbanRailway';
    case REGIONAL_RAIL = 'regionalRail';
    case INTER_REGIONAL_RAIL = 'interregionalRail';
    case LONG_DISTANCE = 'longDistance';
    case INTERNATIONAL = 'international';
    case SLEEPER_RAIL_SERVICE = 'sleeperRailService';
    case NIGHT_RAIL = 'nightRail';
    case CAR_TRANSPORT_RAIL_SERVICE = 'carTransportRailService';
    case TOURIST_RAILWAY = 'touristRailway';
    case RAIL_SHUTTLE = 'railShuttle';
    case REPLACEMENT_RAIL_SERVICE = 'replacementRailService';
    case SPECIAL_TRAIN = 'specialTrain';
    case CROSS_COUNTRY_RAIL = 'crossCountryRail';
    case RACK_AND_PINION_RAILWAY = 'rackAndPinionRailway';
}

