<?php

namespace TriasClient\types\Simple\SubModes;

enum CoachSubmodeEnumeration: string {
    case UNKNOWN = 'unknown';
    case UNDEFINED = 'undefined';
    case INTERNATIONAL_COACH = 'internationalCoach';
    case NATIONAL_COACH = 'nationalCoach';
    case SHUTTLE_COACH = 'shuttleCoach';
    case REGIONAL_COACH = 'regionalCoach';
    case SPECIAL_COACH = 'specialCoach';
    case SIGHTSEEING_COACH = 'sightseeingCoach';
    case TOURIST_COACH = 'touristCoach';
    case COMMUTER_COACH = 'commuterCoach';
}

