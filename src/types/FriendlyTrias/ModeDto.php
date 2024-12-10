<?php

declare(strict_types=1);

namespace TriasClient\types\FriendlyTrias;

use TriasClient\types\Simple\PtModesEnumeration;
use TriasClient\types\Simple\SubModes\AirSubmodeEnumeration;
use TriasClient\types\Simple\SubModes\BusSubmodeEnumeration;
use TriasClient\types\Simple\SubModes\CoachSubmodeEnumeration;
use TriasClient\types\Simple\SubModes\FunicularSubmodeEnumeration;
use TriasClient\types\Simple\SubModes\RailSubmodeEnumeration;
use TriasClient\types\Simple\SubModes\TaxiSubmodeEnumeration;
use TriasClient\types\Simple\SubModes\TelecabinSubmodeEnumeration;
use TriasClient\types\Simple\SubModes\TramSubmodeEnumeration;
use TriasClient\types\Simple\SubModes\WaterSubmodeEnumeration;

class ModeDto
{
    public PtModesEnumeration $mode;
    public AirSubmodeEnumeration|BusSubmodeEnumeration|CoachSubmodeEnumeration|
    FunicularSubmodeEnumeration|RailSubmodeEnumeration|TaxiSubmodeEnumeration|
    TelecabinSubmodeEnumeration|TramSubmodeEnumeration|WaterSubmodeEnumeration|null $submode;
}
