<?php

namespace App\Repositories;

use App\Models\SQL\Report;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
     * @param int|null $limit
     * @param array    $filters
     * @return LengthAwarePaginator
     */
    public function getReports(int $limit = 15 , array $filters = []): LengthAwarePaginator
    {
        $query = Report::filter($filters)->orderBy('DateEntered');

        return $query->paginateFilter($limit);
    }
}
