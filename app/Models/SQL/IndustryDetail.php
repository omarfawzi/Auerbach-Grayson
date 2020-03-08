<?php

namespace App\Models\SQL;

use Illuminate\Database\Eloquent\Model;

class IndustryDetail extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'IndustryDetail';
}
