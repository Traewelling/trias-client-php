<?php

namespace TriasClient\types\Simple\SubModes;

enum WaterSubmodeEnumeration: string {
    case UNKNOWN = 'unknown';
    case UNDEFINED = 'undefined';
    case INTERNATIONAL_CAR_FERRY = 'internationalCarFerry';
    case NATIONAL_CAR_FERRY = 'nationalCarFerry';
    case REGIONAL_CAR_FERRY = 'regionalCarFerry';
    case LOCAL_CAR_FERRY = 'localCarFerry';
    case INTERNATIONAL_PASSENGER_FERRY = 'internationalPassengerFerry';
    case NATIONAL_PASSENGER_FERRY = 'nationalPassengerFerry';
    case REGIONAL_PASSENGER_FERRY = 'regionalPassengerFerry';
    case LOCAL_PASSENGER_FERRY = 'localPassengerFerry';
    case POST_BOAT = 'postBoat';
    case TRAIN_FERRY = 'trainFerry';
    case ROAD_FERRY_LINK = 'roadFerryLink';
    case AIRPORT_BOAT_LINK = 'airportBoatLink';
    case HIGH_SPEED_VEHICLE_SERVICE = 'highSpeedVehicleService';
    case HIGH_SPEED_PASSENGER_SERVICE = 'highSpeedPassengerService';
    case SIGHTSEEING_SERVICE = 'sightseeingService';
    case SCHOOL_BOAT = 'schoolBoat';
    case CABLE_FERRY = 'cableFerry';
    case RIVER_BUS = 'riverBus';
    case SCHEDULED_FERRY = 'scheduledFerry';
    case SHUTTLE_FERRY_SERVICE = 'shuttleFerryService';
}

