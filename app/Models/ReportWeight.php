<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportWeight extends Model
{
    public const COMPANY_WEIGHT = 2;
    public const SUBSCRIPTION_WEIGHT = 1;

    protected $connection = 'mysql';
}
