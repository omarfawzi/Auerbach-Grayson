<?php

namespace App\Models\SQL;

use App\Contracts\Mailable;
use App\Models\ReportView;
use App\Models\SavedReport;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Report extends Model implements Mailable
{
    use Filterable;

    protected $casts = [
        'Pages' => 'int',
    ];

    protected $connection = 'sqlsrv';

    protected $table = 'Report';

    protected $primaryKey = 'ReportID';

    public function getReportTitleAttribute()
    {
        return str_replace('AUERBACH GRAYSON:', '', $this->Title);
    }
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

    public function isSaved()
    {
        return $this->hasOne(SavedReport::class, 'report_id', 'ReportID')->where(
            'user_id',
            Auth::user()->id
        );
    }
}
