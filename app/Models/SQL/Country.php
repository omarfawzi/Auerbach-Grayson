<?php

namespace App\Models\SQL;

use App\Contracts\Subscribable;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;

class Country extends Model implements Subscribable
{
    protected $connection = 'sqlsrv';

    protected $table = 'Country';

    protected $primaryKey = 'CountryID';

    public function region()
    {
        return $this->belongsTo(Region::class,'RegionId','RegionId');
    }

    public function subscriptions()
    {
        return $this->morphMany(Subscription::class,'subscribable',null,null,'CountryID');
    }
}
