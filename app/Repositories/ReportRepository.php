<?php

namespace App\Repositories;

use App\Models\SQL\Report;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportRepository
{
    /**
     * @param int $id
     * @return Report|null
     */
    public function getReport(int $id): ?Report
    {
        return Report::findOrFail($id);
    }

    /**
     * @param int|null $limit
     * @param array    $filters
     * @return LengthAwarePaginator
     */
    public function getReports(int $limit, array $filters = []): LengthAwarePaginator
    {
        /** @var Builder $queryBuilder */
        $queryBuilder = Report::filter($filters);

        return $queryBuilder->with('type')->where('Approved', 1)->orderBy('ReportDate', 'DESC')->paginateFilter($limit);
    }

}
