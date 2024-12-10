<?php

namespace TriasClient\types\Simple;


enum ContinuousModesEnumeration: string {
    case WALK = 'walk';
    case DEMAND_RESPONSIVE = 'demandResponsive';
    case REPLACEMENT_SERVICE = 'replacementService';
}
