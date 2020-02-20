<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

class ReportFilter extends ModelFilter
{
    protected $relationsEnabled = true;

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
