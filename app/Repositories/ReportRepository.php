<?php

namespace App\Repositories;

use App\Models\SQL\Report;
use Illuminate\Database\Eloquent\Builder;

class ReportRepository
{
    /**
     * @param string $type
     * @param int|null $limit
     * @return Report[]|null
     */
    public function getReportsByType(string $type, ?int $limit) : ?array
    {
        /** @var Builder $query */
        $query = Report::whereHas(
            'type',
            function (Builder $query) use ($type) {
                $query->where('Type.Type','=', $type);
            }
        )->orderBy('DateEntered');

        if ($limit)
        {
            $query->limit($limit);
        }

        return $query->get()->all();
    }
}
