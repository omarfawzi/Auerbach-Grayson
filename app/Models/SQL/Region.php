<?php

namespace App\Models\SQL;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'Region';

    protected $primaryKey = 'RegionId';

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->RegionId,
            'name' => $this->Region
        ];
    }
}
