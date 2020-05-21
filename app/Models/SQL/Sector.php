<?php

namespace App\Models\SQL;

use App\Contracts\Subscribable;
use App\Models\Subscription;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model implements Subscribable
{
    use Filterable;

    protected $connection = 'sqlsrv';

    protected $table = 'GICS_Sector';

    protected $primaryKey = 'GICS_SectorId';

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public static function getPrimaryKey()
    {
        return with(new static)->getKeyName();
    }

    public function subscriptions()
    {
        return $this->morphMany(Subscription::class,'subscribable',null,null,'GICS_SectorId');
    }

    public function industryDetails()
    {
        return $this->hasManyThrough(IndustryDetail::class,Industry::class,'GICS_SectorId','IndustryID','GICS_SectorId','IndustryID');
    }
}
