<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

class ReportFilter extends ModelFilter
{
    protected $relationsEnabled = true;

    /**
     * @param string $company
     * @return ReportFilter|Builder
     */
    public function company(string $company)
    {
        return $this->whereHas(
            'companies',
            function (Builder $query) use ($company) {
                $query->where('Company.Company', '=', $company)->orWhere('Company.Bloomberg', '=', $company);
            }
        );
    }

    /**
     * @param string $country
     * @return ReportFilter|Builder
     */
    public function country(string $country)
    {
        return $this->whereHas(
            'countries',
            function (Builder $query) use ($country) {
                $query->where('Country.Country', '=', $country)->orWhereHas(
                        'region',
                        function (Builder $query) use ($country) {
                            $query->where('Region.Region', '=', $country);
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
                $query->where('Type.Type', '=', $type);
            }
        );
    }
}
