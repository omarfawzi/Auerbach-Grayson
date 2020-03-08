<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscribtion extends Model
{
    private const SECTOR_SUBSCRIBTION_TYPE = 'sector';

    private const COMPANY_SUBSCRIBTION_TYPE = 'company';

    public const SUBSCRIPTION_TYPES = [
        self::SECTOR_SUBSCRIBTION_TYPE,
        self::COMPANY_SUBSCRIBTION_TYPE
    ];

}
