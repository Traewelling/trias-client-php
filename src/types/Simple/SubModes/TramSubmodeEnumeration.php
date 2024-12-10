<?php

namespace TriasClient\types\Simple\SubModes;

enum TramSubmodeEnumeration: string {
    case UNKNOWN = 'unknown';
    case UNDEFINED = 'undefined';
    case CITY_TRAM = 'cityTram';
    case LOCAL_TRAM = 'localTram';
    case REGIONAL_TRAM = 'regionalTram';
    case SIGHTSEEING_TRAM = 'sightseeingTram';
    case SHUTTLE_TRAM = 'shuttleTram';
}
