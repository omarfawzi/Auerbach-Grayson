<?php

namespace App\Models\SQL;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'Type';

    protected $primaryKey = 'TypeID';
}
