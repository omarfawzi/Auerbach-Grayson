<?php

namespace App\Models\SQL;

use App\Models\ReportView;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use Filterable;

    protected $casts = [
        'Pages' => 'int'
    ];

    protected $connection = 'sqlsrv';

    protected $table = 'Report';

    protected $primaryKey = 'ReportID';

    public function type()
    {
        return $this->belongsTo(Type::class,'TypeID','TypeID');
    }

    public function countries()
    {
        return $this->hasManyThrough(Country::class,CountryDetail::class,'ReportID','CountryID','ReportID','CountryID');
    }

    public function companies()
    {
        return $this->hasManyThrough(Company::class,CompanyDetail::class,'ReportID','CompanyID','ReportID','CompanyID');
    }

    public function recommendations()
    {
        return $this->hasManyThrough(Recommendation::class,CompanyDetail::class,'ReportID','RecommendID','ReportID','RecommendID');
    }

    public function views()
    {
        return $this->hasMany(ReportView::class,'report_id','ReportID');
    }

    public function analysts()
    {
        return $this->hasManyThrough(Analyst::class,AnalystDetail::class,'ReportID','AnalystID','ReportID','AnalystID');
    }
}
