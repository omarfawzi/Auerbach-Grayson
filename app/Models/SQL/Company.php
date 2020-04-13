<?php

namespace App\Models\SQL;

use App\Contracts\Subscribable;
use App\Models\Subscription;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Company extends Model implements Subscribable
{
    use Filterable;

    protected $connection = 'sqlsrv';

    protected $table = 'Company';

    protected $primaryKey = 'CompanyID';

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public static function getPrimaryKey()
    {
        return with(new static)->getKeyName();
    }

    /**
     * @return string
     */
    public function getTicker(): string
    {
        return $this->Bloomberg;
    }

    public function industry()
    {
        return $this->hasOneThrough(Industry::class,IndustryDetail::class,'CompanyID','IndustryID','CompanyID','IndustryID');
    }

    public function subscriptions()
    {
        return $this->morphMany(Subscription::class,'subscribable',null,null,'CompanyID');
    }

    public function recommendation()
    {
        return $this->hasOneThrough(Recommendation::class,CompanyDetail::class,'CompanyID','RecommendID','CompanyID','RecommendID');
    }

    public function detail()
    {
        return $this->hasOne(CompanyDetail::class,'CompanyID','CompanyID');
    }

    public function marketCap()
    {
        return $this->hasOne(MarketCap::class,'MarketCapId','MarketCapId');
    }
}
