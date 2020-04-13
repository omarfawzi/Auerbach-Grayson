<?php

namespace App\Models\SQL;

use Illuminate\Database\Eloquent\Model;

class MarketCap extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'MarketCap';
}
