<?php

namespace App\Models\SQL;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use Filterable;

    protected $connection = 'sqlsrv';

    protected $table = 'Type';

    protected $primaryKey = 'TypeID';
}
