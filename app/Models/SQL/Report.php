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
        return $this->belongsTo(Type::class,'TypeID','TypeID');
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id'    => $this->ReportID,
            'title' => $this->Title,
            'synopsis' => $this->Synopsis,
            'date' => $this->ReportDate,
            'pages' => $this->Pages,
            'by' => $this->AnalystIndex,
            'type' => optional($this->type)->Type
        ];
    }
}
