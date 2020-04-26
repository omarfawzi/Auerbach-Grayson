<?php

namespace App\Models\Filters;

use App\Factories\DateFactory;
use App\Repositories\SavedReportRepository;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportFilter extends ModelFilter
{
    protected $relationsEnabled = true;

    /**
     * @param array $values
     * @return ReportFilter|Builder
     */
    public function company(array $values)
    {
        return $this->whereHas(
            'companies',
            function (Builder $query) use ($values) {
                $query->whereIn('Company', $values);
                if ($this->input('recommendation')) {
                    $query->join(
                        'Recommendation',
                        'Recommendation.RecommendID',
                        '=',
                        'CompanyReportDetail.RecommendID'
                    )->whereIn('Recommendation.Recommendation', $this->input('recommendation'));
                }
                if ($this->input('sector')) {
                    $query->join(
                        'IndustryDetail',
                        'IndustryDetail.CompanyID',
                        '=',
                        'Company.CompanyID'
                    )->join(
                        'Industry',
                        'Industry.IndustryID',
                        '=',
                        'IndustryDetail.IndustryID'
                    )->join(
                        'GICS_Sector',
                        'GICS_Sector.GICS_SectorId',
                        '=',
                        'Industry.GICS_SectorId'
                    )->whereIn('GICS_Sector.GICS_Sector', $this->input('sector'));
                }
            }
        );
    }

    /**
     * @param array $values
     * @return ReportFilter|Builder
     */
    public function country(array $values)
    {
        return $this->whereHas(
            'countries',
            function (Builder $query) use ($values) {
                $query->whereIn('Country', $values)->orWhereHas(
                    'region',
                    function (Builder $query) use ($values) {
                        $query->whereIn('Region', $values);
                    }
                );
            }
        );
    }

    /**
     * @param string $date
     * @return ReportFilter|\Illuminate\Database\Query\Builder
     */
    public function date(string $date)
    {
        return $this->whereDate('ReportDate', '>=', (new DateFactory())->make($date));
    }

    /**
     * @param array $values
     * @return ReportFilter|Builder
     */
    public function recommendation(array $values)
    {
        if ($this->input('company')) {
            return null;
        } else {
            return $this->whereHas(
                'recommendation',
                function (Builder $query) use ($values) {
                    $query->whereIn('Recommendation', $values);
                }
            );
        }
    }

    /**
     * @param string $searchKey
     * @return ReportFilter|Builder
     */
    public function searchKey(string $searchKey)
    {
        $searchKey = strtolower($searchKey);
        return $this->whereRaw('LOWER(Title) like ?', ["%$searchKey%"])
            ->orWhereRaw(
                'LOWER(FirstLine) like ?',
                ["%$searchKey%"])
            ->orWhereRaw(
                'LOWER(CAST(Synopsis as varchar(1000))) like ?',
                ["%$searchKey%"]
            );
    }

    /**
     * @param array $values
     * @return ReportFilter|Builder|null
     */
    public function sector(array $values)
    {
        if ($this->input('company')) {
            return null;
        } else {
            return $this->whereHas(
                'companies',
                function (Builder $query) use ($values) {
                    $query->whereHas(
                        'industry',
                        function (Builder $query) use ($values) {
                            $query->whereHas(
                                'sector',
                                function (Builder $query) use ($values) {
                                    $query->whereIn('GICS_Sector', $values);
                                }
                            );
                        }
                    );
                }
            );
        }
    }

    /**
     * @param string $type
     * @return ReportFilter|Builder
     */
    public function type(string $type)
    {
        return $this->whereHas(
            'type',
            function (Builder $query) use ($type) {
                $query->where('Type', $type);
            }
        );
    }

    /**
     * @param bool $saved
     * @return ReportFilter|null
     */
    public function saved(bool $saved)
    {
        return $saved ? $this->whereIn(
            'ReportID',
            app(SavedReportRepository::class)->getUserSavedReportsIds(Auth::user()->id)
        ) : null;
    }

    /**
     * @param bool $trending
     * @return ReportFilter|null
     */
    public function trending(bool $trending)
    {
        if ($trending) {
            $trendingReportsIds = $this->getTrendingReportsIds($this->input('limit', config('api.defaults.limit')));
            $orderByCase        = '';
            foreach ($trendingReportsIds as $index => $trendingReportsId) {
                $orderByCase .= "WHEN $trendingReportsId THEN $index ";
            }

            return $this->whereIn('ReportID', $trendingReportsIds)->orderByRaw(
                sprintf('CASE ReportID %s END', $orderByCase)
            );
        }

        return null;
    }

    /**
     * @param int $limit
     * @return array
     */
    private function getTrendingReportsIds(int $limit): array
    {
        return DB::table('report_views')->whereDate(
            'created_at',
            '>=',
            (new DateFactory())->make(config('api.reports.last_trend_date'))
        )->select(['report_id', DB::raw('COUNT(id) as views_count')])->orderBy(
            'views_count',
            'desc'
        )->groupBy('report_id')->limit($limit)->get()->pluck('report_id')->toArray();
    }
}
