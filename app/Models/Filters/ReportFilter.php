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
                $query->whereIn('Company.Company', $values);
                if ($this->input('recommendation')) {
                    $query->join(
                        'Recommendation',
                        'Recommendation.RecommendID',
                        '=',
                        'CompanyDetail.RecommendID',
                        'inner'
                    )->where(
                        function ($query) use ($values) {
                            $query->whereIn('Recommendation.Recommendation', $this->input('recommendation'));
                        }
                    );
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
                $query->whereIn('Country.Country', $values)->orWhereHas(
                    'region',
                    function (Builder $query) use ($values) {
                        $query->whereIn('Region.Region', $values);
                    }
                );
            }
        );
    }

    /**
     * @param array $values
     * @return ReportFilter|Builder
     */
    public function recommendation($values)
    {
        if ($this->input('company')) {
            return null;
        } else {
            return $this->whereHas(
                'recommendations',
                function (Builder $query) use ($values) {
                    $query->whereIn('Recommendation.Recommendation', $values);
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
                $query->where('Type.Type', $type);
            }
        );
    }
}
