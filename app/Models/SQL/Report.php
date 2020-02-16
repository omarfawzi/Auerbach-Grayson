<?php

namespace App\Models\SQL;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use Filterable;

    protected $connection = 'sqlsrv';

    protected $table = 'Report';

    protected $primaryKey = 'ReportID';

    public function type()
    {
        return $this->hasOne(Type::class,'TypeID','TypeID');
    }
}
