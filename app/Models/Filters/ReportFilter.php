<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

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
                        'CompanyDetail.RecommendID'
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
     * @param array $values
     * @return ReportFilter|Builder
     */
    public function recommendation(array $values)
    {
        if ($this->input('company')) {
            return null;
        } else {
            return $this->whereHas(
                'recommendations',
                function (Builder $query) use ($values) {
                    $query->whereIn('Recommendation', $values);
                }
            );
        }
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
                        'industries',
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
     * @param string $title
     * @return ReportFilter|Builder
     */
    public function title(string $title)
    {
        return $this->where('title', 'like', "%$title%");
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
}
