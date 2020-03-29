<?php

namespace App\Repositories;

use App\Factories\DateFactory;
use App\Models\SQL\Report;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

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
    public function getReports(int $limit, array $filters = []) : LengthAwarePaginator
    {
        /** @var Builder $queryBuilder */
        $queryBuilder = Report::filter($filters)->where('Approved', 1)->orderBy('ReportDate', 'DESC');
        if (isset($filters['trending']) && $filters['trending']) {
            $trendingReportsIds = $this->getTrendingReportsIds($limit);
            $queryBuilder->whereIn('ReportID',$trendingReportsIds);
            $trendingReportsOrder = [];
            foreach ($trendingReportsIds as $index => $trendingReportsId)
            {
                $trendingReportsOrder[$trendingReportsId] = $index;
            }
            $sortedCollection = $queryBuilder->get()->sort(
                function (Report $report) use ($trendingReportsOrder) {
                    return $trendingReportsOrder[$report->ReportID];
                }
            );
            $paginated        = $sortedCollection->forPage($filters['page'] ?? 1, $limit);

            return new LengthAwarePaginator($paginated, $sortedCollection->count(), $limit);
        } else {
            return $queryBuilder->paginateFilter($limit);
        }
    }

    /**
     * @param int $limit
     * @return array
     */
    private function getTrendingReportsIds(int $limit) : array
    {
        return DB::table('report_views')->whereDate(
            'created_at',
            '>=',
            (new DateFactory())->make(config('api.reports.last_trend_date'))
        )->select(['report_id', DB::raw('COUNT(id) as views_count')])->orderBy(
            'views_count',
            'desc'
        )->groupBy('report_id')->limit($limit)->get()->pluck('report_id')->toArray();
    }
}
