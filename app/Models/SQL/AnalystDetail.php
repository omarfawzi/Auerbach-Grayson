<?php

namespace App\Models\SQL;

use Illuminate\Database\Eloquent\Model;

class AnalystDetail extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'AnalystDetail';
}
