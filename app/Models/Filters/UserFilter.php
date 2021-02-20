<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter
{
    /**
     * @param string $name
     * @return UserFilter
     */
    public function name(string $name)
    {
        $name = strtolower($name);
        return $this->whereRaw('(LOWER(name) like ? OR LOWER(email) like ? )',["%$name%", "%$name%"]);
    }
    public function admin(int $is_admin)
    {
        if($is_admin){
            return $this->whereRaw('is_admin = 1');
        }
        return $this->whereRaw('is_admin = 0');
    }

    public function available(bool $is_available)
    {
        if($is_available){
            return $this->whereRaw('is_available = 1');
        }
        return $this->whereRaw('is_available = 0');
    }

}
