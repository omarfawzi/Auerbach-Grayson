<?php

namespace App\Repositories;

use App\Models\SQL\Report;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ReportRepository
{
    /**
     * @param int $id
     * @return Report|null
     */
    public function getReportById(int $id): ?Report
    {
        return Report::findOrFail($id);
    }

    /**
     * @param string   $type
     * @param int|null $limit
     * @return LengthAwarePaginator
     */
    public function getReports(?string $type, int $limit = 15): LengthAwarePaginator
    {
        /** @var Builder $query */
        $query = Report::orderBy('DateEntered');

        if ($type){
            $query->whereHas(
                'type',
                function (Builder $query) use ($type) {
                    $query->where('Type.Type', '=', $type);
                }
            );
        }

        return $query->paginate($limit);
    }
}
