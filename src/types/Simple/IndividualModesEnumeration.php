<?php

declare(strict_types=1);

namespace TriasClient\types\Simple;

enum IndividualModesEnumeration: string {
    case WALK = 'walk';
    case CYCLE = 'cycle';
    case TAXI = 'taxi';
    case SELF_DRIVE_CAR = 'self-drive-car';
    case OTHERS_DRIVE_CAR = 'others-drive-car';
    case MOTORCYCLE = 'motorcycle';
    case TRUCK = 'truck';
}

