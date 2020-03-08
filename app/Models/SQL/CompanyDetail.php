<?php

namespace App\Models\SQL;

use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'CompanyDetail';
}
