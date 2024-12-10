<?php

namespace TriasClient\types\Simple;

enum PtModesEnumeration: string {
    case ALL = 'all';
    case UNKNOWN = 'unknown';
    case AIR = 'air';
    case BUS = 'bus';
    case TROLLEY_BUS = 'trolleyBus';
    case TRAM = 'tram';
    case COACH = 'coach';
    case RAIL = 'rail';
    case INTERCITY_RAIL = 'intercityRail';
    case URBAN_RAIL = 'urbanRail';
    case METRO = 'metro';
    case WATER = 'water';
    case CABLEWAY = 'cableway';
    case FUNICULAR = 'funicular';
    case TAXI = 'taxi';
}

