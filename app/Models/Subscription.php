<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use Filterable;

    public const SECTOR_SUBSCRIPTION_TYPE = 'sector';

    public const COMPANY_SUBSCRIPTION_TYPE = 'company';

    public const COUNTRY_SUBSCRIPTION_TYPE = 'country';

    public const SUBSCRIPTION_TYPES = [
        self::SECTOR_SUBSCRIPTION_TYPE,
        self::COMPANY_SUBSCRIPTION_TYPE,
        self::COUNTRY_SUBSCRIPTION_TYPE
    ];

    protected $connection = 'mysql';

    public function subscribable()
    {
        if ($this->getAttribute('subscribable_type') == self::SECTOR_SUBSCRIPTION_TYPE) {
            $this->setAttribute('subscribable_id', strval($this->getAttribute('subscribable_id')));
        }
        return $this->morphTo();
    }

}
