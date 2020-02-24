<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

class ReportFilter extends ModelFilter
{
    protected $relationsEnabled = true;

    /**
     * @param array $searchValue
     * @return ReportFilter|Builder
     */
    public function company(array $searchValue)
    {
        return $this->whereHas(
            'companies',
            function (Builder $query) use ($searchValue) {
                $query->whereIn('Company.Company', $searchValue)->orWhereIn('Company.Bloomberg', $searchValue);
            }
        );
    }

    /**
     * @param array $searchValue
     * @return ReportFilter|Builder
     */
    public function country(array $searchValue)
    {
        return $this->whereHas(
            'countries',
            function (Builder $query) use ($searchValue) {
                $query->whereIn('Country.Country',$searchValue)->orWhereHas(
                        'region',
                        function (Builder $query) use ($searchValue) {
                            $query->whereIn('Region.Region', $searchValue);
                        }
                    );
            }
        );
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
                $query->where('Type.Type',$type);
            }
        );
    }
}
