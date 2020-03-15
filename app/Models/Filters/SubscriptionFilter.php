<?php


namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class SubscriptionFilter extends ModelFilter
{
    public function type(string $type)
    {
        return $this->where('subscribable_type',$type);
    }
}
