<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class SectorFilter extends ModelFilter
{
    /**
     * @param string $name
     * @return SectorFilter
     */
    public function name(string $name)
    {
        $name = strtolower($name);
        return $this->whereRaw('LOWER(GICS_Sector) like ?',["%$name%"]);
    }
}
