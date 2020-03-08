<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    private const SECTOR_SUBSCRIPTION_TYPE = 'sector';

    private const COMPANY_SUBSCRIPTION_TYPE = 'company';

    public const SUBSCRIPTION_TYPES = [
        self::SECTOR_SUBSCRIPTION_TYPE,
        self::COMPANY_SUBSCRIPTION_TYPE
    ];

}
