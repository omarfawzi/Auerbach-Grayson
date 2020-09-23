<?php

namespace App\Models\SQL;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'Industry';

    protected $primaryKey = 'IndustryID';

    public function sector()
    {
        return $this->belongsTo(Sector::class,'GICS_SectorId','GICS_SectorId');
    }

    public function companies()
    {
        return $this->hasManyThrough(Company::class,IndustryDetail::class,'IndustryID','CompanyID','IndustryID','CompanyID');
    }
}
