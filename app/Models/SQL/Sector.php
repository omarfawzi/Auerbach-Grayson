<?php

namespace App\Models\SQL;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{

    protected $connection = 'sqlsrv';

    protected $table = 'GICS_Sector';

    protected $primaryKey = 'GICS_SectorId';

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->GICS_SectorId,
            'name' => $this->GICS_Sector
        ];
    }
}
