<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class CompanyFilter extends ModelFilter
{
    /**
     * @param string $name
     * @return CompanyFilter
     */
    public function name(string $name)
    {
        $name = strtolower($name);
        return $this->whereRaw('LOWER(Company) like ? OR LOWER(Bloomberg) like ? ',["%$name%", "%$name%"]);
    }

}
