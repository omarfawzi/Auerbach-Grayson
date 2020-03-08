<?php

namespace App\Models\SQL;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'Company';

    protected $primaryKey = 'CompanyID';

    /**
     * @return string
     */
    public function getTicker(): string
    {
        return $this->Bloomberg;
    }

    public function industries()
    {
        return $this->hasManyThrough(Industry::class,IndustryDetail::class,'CompanyID','IndustryID','CompanyID','IndustryID');
    }

    public function subscription()
    {
        return $this->morphMany(Subscription::class,'subscribable',null,'relationId','CompanyID');
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'     => $this->CompanyID,
            'title'  => $this->Company,
            'ticker' => $this->getTicker(),
        ];
    }
}
