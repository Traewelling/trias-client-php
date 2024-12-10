<?php

namespace TriasClient\types\Simple\SubModes;

enum BusSubmodeEnumeration: string {
    case UNKNOWN = 'unknown';
    case UNDEFINED = 'undefined';
    case LOCAL_BUS = 'localBus';
    case REGIONAL_BUS = 'regionalBus';
    case EXPRESS_BUS = 'expressBus';
    case NIGHT_BUS = 'nightBus';
    case POST_BUS = 'postBus';
    case SPECIAL_NEEDS_BUS = 'specialNeedsBus';
    case MOBILITY_BUS = 'mobilityBus';
    case MOBILITY_BUS_FOR_REGISTERED_DISABLED = 'mobilityBusForRegisteredDisabled';
    case SIGHTSEEING_BUS = 'sightseeingBus';
    case SHUTTLE_BUS = 'shuttleBus';
    case SCHOOL_BUS = 'schoolBus';
    case SCHOOL_AND_PUBLIC_SERVICE_BUS = 'schoolAndPublicServiceBus';
    case RAIL_REPLACEMENT_BUS = 'railReplacementBus';
    case DEMAND_AND_RESPONSE_BUS = 'demandAndResponseBus';
    case AIRPORT_LINK_BUS = 'airportLinkBus';
}


