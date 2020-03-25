<?php

namespace App\Models\SQL;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'Type';

    protected $primaryKey = 'TypeID';

    public function toArray()
    {
        return [
            'id' => $this->TypeID,
            'name' => $this->Type
        ];
    }
}
