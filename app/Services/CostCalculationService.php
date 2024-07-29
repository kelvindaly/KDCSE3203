<?php

namespace App\Services;

use App\Models\Zone;
use App\Models\PackagePriority;
use App\Models\PackageSize;

class CostCalculationService
{
    public static function calculate($zoneId, $priorityId, $sizeId)
    {
        $zone = Zone::findOrFail($zoneId);
        $priority = PackagePriority::findOrFail($priorityId);
        $size = PackageSize::findOrFail($sizeId);

        return $zone->flat_rate + $priority->priority_rate + $size->size_rate;
    }
}
