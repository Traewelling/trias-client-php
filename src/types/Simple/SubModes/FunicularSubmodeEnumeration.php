<?php

namespace TriasClient\types\Simple\SubModes;

enum FunicularSubmodeEnumeration: string {
    case UNKNOWN = 'unknown';
    case FUNICULAR = 'funicular';
    case ALL_FUNICULAR_SERVICES = 'allFunicularServices';
    case UNDEFINED_FUNICULAR = 'undefinedFunicular';
}
