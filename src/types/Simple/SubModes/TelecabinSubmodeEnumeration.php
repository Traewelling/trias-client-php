<?php

namespace TriasClient\types\Simple\SubModes;

enum TelecabinSubmodeEnumeration: string {
    case UNKNOWN = 'unknown';
    case UNDEFINED = 'undefined';
    case TELECABIN = 'telecabin';
    case CABLE_CAR = 'cableCar';
    case LIFT = 'lift';
    case CHAIR_LIFT = 'chairLift';
    case DRAG_LIFT = 'dragLift';
    case TELECABIN_LINK = 'telecabinLink';
}

