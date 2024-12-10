<?php

declare(strict_types=1);

namespace TriasClient\trias\Service;

use ReflectionClass;
use TriasClient\types\FriendlyTrias\ModeDto;
use TriasClient\types\Simple\PtModesEnumeration;
use TriasClient\types\Simple\SubModes\AirSubmodeEnumeration;
use TriasClient\types\Simple\SubModes\BusSubmodeEnumeration;
use TriasClient\types\Simple\SubModes\CoachSubmodeEnumeration;
use TriasClient\types\Simple\SubModes\FunicularSubmodeEnumeration;
use TriasClient\types\Simple\SubModes\MetroSubmodeEnumeration;
use TriasClient\types\Simple\SubModes\RailSubmodeEnumeration;
use TriasClient\types\Simple\SubModes\TaxiSubmodeEnumeration;
use TriasClient\types\Simple\SubModes\TelecabinSubmodeEnumeration;
use TriasClient\types\Simple\SubModes\TramSubmodeEnumeration;
use TriasClient\types\Simple\SubModes\WaterSubmodeEnumeration;

class TypeService
{
    public function getMode(object $object): ModeDto {
        $dto = new ModeDto();

        $dto->mode = PtModesEnumeration::tryFrom($object->PtMode);
        $dto->submode = $this->getSubmodule($object);

        return $dto;
    }

    private function getSubmodule(object $object): ?object{
        $submodules = [
            AirSubmodeEnumeration::class,
            BusSubmodeEnumeration::class,
            CoachSubmodeEnumeration::class,
            FunicularSubmodeEnumeration::class,
            MetroSubmodeEnumeration::class,
            RailSubmodeEnumeration::class,
            TaxiSubmodeEnumeration::class,
            TelecabinSubmodeEnumeration::class,
            TramSubmodeEnumeration::class,
            WaterSubmodeEnumeration::class,
        ];

        foreach ($submodules as $submodule) {
            $submoduleName = substr($submodule, strrpos($submodule, '\\')+1);
            $submoduleName = str_replace('Enumeration', '', $submoduleName);

            if (property_exists($object, $submoduleName) && $object->$submoduleName !== null) {
                return ($submodule)::tryFrom($object->$submoduleName);
            }
        }

        return null;
    }

}
