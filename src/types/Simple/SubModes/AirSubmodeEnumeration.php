<?php

namespace TriasClient\types\Simple\SubModes;

enum AirSubmodeEnumeration: string {
    case UNKNOWN = 'unknown';
    case UNDEFINED = 'undefined';
    case INTERNATIONAL_FLIGHT = 'internationalFlight';
    case DOMESTIC_FLIGHT = 'domesticFlight';
    case INTERCONTINENTAL_FLIGHT = 'intercontinentalFlight';
    case DOMESTIC_SCHEDULED_FLIGHT = 'domesticScheduledFlight';
    case SHUTTLE_FLIGHT = 'shuttleFlight';
    case INTERCONTINENTAL_CHARTER_FLIGHT = 'intercontinentalCharterFlight';
    case INTERNATIONAL_CHARTER_FLIGHT = 'internationalCharterFlight';
    case ROUND_TRIP_CHARTER_FLIGHT = 'roundTripCharterFlight';
    case SIGHTSEEING_FLIGHT = 'sightseeingFlight';
    case HELICOPTER_SERVICE = 'helicopterService';
    case DOMESTIC_CHARTER_FLIGHT = 'domesticCharterFlight';
    case SCHENGEN_AREA_FLIGHT = 'SchengenAreaFlight';
    case AIRSHIP_SERVICE = 'airshipService';
    case SHORT_HAUL_INTERNATIONAL_FLIGHT = 'shortHaulInternationalFlight';
    case CANAL_BARGE = 'canalBarge';
}

