<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class RegionFilter extends ModelFilter
{
    /**
     * @param string $name
     * @return RegionFilter
     */
    public function name(string $name)
    {
        $name = strtolower($name);
        return $this->whereRaw('LOWER(Region) like ?',["%$name%"]);
    }
}
