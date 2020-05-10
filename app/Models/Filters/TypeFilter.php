<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class TypeFilter extends ModelFilter
{
    /**
     * @param string $name
     * @return TypeFilter
     */
    public function name(string $name)
    {
        $name = strtolower($name);
        return $this->whereRaw('LOWER(Type) like ?',["%$name%"]);
    }
}
