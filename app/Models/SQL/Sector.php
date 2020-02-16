<?php

namespace App\Models\SQL;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'GICS_Sector';

    protected $primaryKey = 'GICS_SectorId';
}
