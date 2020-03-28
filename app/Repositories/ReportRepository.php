<?php

namespace App\Repositories;

use App\Models\SQL\Report;
use Illuminate\Database\Query\Builder;
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
    public function getReports(int $limit, array $filters = [])
    {
        /** @var Builder $result */
        $result = Report::filter($filters)->where('Approved', 1)->orderBy('ReportDate', 'DESC');
        if (isset($filters['trending'])) {
            $sortedCollection = $result->get()->sortByDesc(
                function (Report $report) {
                    return $report->views()->count('id');
                }
            );
            $paginated        = $sortedCollection->forPage($filters['page'] ?? 1, $limit);

            return new LengthAwarePaginator($paginated, $sortedCollection->count(), $limit);
        } else {
            return $result->paginateFilter($limit);
        }

    }
}
