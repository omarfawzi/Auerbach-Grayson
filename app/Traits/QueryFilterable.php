<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

trait QueryFilterable
{
    /**
     * Scope a query for query builder.
     *
     * @param Builder $query
     * @param Request $request
     * @return Builder
     */
    public function scopeFilter(Builder $query, Request $request): Builder
    {
        $query = new QueryBuilder($this->query(), $request);

        switch (true) {
            case property_exists($this, 'filterable'):
                $query = $query->allowedFilters($this->filterable);
                break;
            case property_exists($this, 'sortable'):
                $query = $query->allowedSorts($this->sortable);
                break;

            case property_exists($this, 'includable'):
                $query = $query->allowedIncludes($this->includable);
                break;

            case property_exists($this, 'visible'):
                $query = $query->allowedFields($this->visible);
                break;

            case property_exists($this, 'appendable'):
                $query = $query->allowedAppends($this->appendable);
                break;
        }

        return $query;
    }
}
