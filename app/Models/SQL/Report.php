<?php

namespace App\Models\SQL;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'Report';

    protected $primaryKey = 'ReportID';

    public function type()
    {
        return $this->hasOne(Type::class,'TypeID','TypeID');
    }
}
