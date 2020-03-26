<?php

namespace App\Models\SQL;

use Illuminate\Database\Eloquent\Model;

class Analyst extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'Analyst';

    protected $primaryKey = 'AnalystID';
}
