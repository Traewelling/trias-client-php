<?php

namespace TriasClient\types\Simple;

enum InterchangeModesEnumeration: string {
    case WALK = 'walk';
    case PARK_AND_RIDE = 'parkAndRide';
    case BIKE_AND_RIDE = 'bikeAndRide';
    case CAR_HIRE = 'carHire';
    case BIKE_HIRE = 'bikeHire';
    case PROTECTED_CONNECTION = 'protectedConnection';
    case GUARANTEED_CONNECTION = 'guaranteedConnection';
    case REMAIN_IN_VEHICLE = 'remainInVehicle';
    case CHANGE_WITHIN_VEHICLE = 'changeWithinVehicle';
    case CHECK_IN = 'checkIn';
    case CHECK_OUT = 'checkOut';
}

