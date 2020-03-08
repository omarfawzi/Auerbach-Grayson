<?php

namespace App\Models\SQL;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'Country';

    protected $primaryKey = 'CountryID';

    public function region()
    {
        return $this->belongsTo(Region::class,'RegionId','RegionId');
    }
}
