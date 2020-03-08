<?php

namespace App\Models\SQL;

use Illuminate\Database\Eloquent\Model;

class CountryDetail extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'CountryDetail';
}
