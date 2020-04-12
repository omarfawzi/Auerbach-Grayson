<?php

namespace App\Repositories;

use App\Factories\DateFactory;
use App\Models\SQL\Report;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportRepository
{
    /** @var SavedReportRepository $savedReportRepository */
    protected $savedReportRepository;

    /**
     * ReportRepository constructor.
     *
     * @param SavedReportRepository $savedReportRepository
     */
    public function __construct(SavedReportRepository $savedReportRepository)
    {
        $this->savedReportRepository = $savedReportRepository;
    }


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
        if (isset($filters['trending']) && $filters['trending']) {

            $collection = $this->getTrendingReportsCollection($queryBuilder, $limit);
            $paginated  = $collection->forPage($filters['page'] ?? 1, $limit);

            return new LengthAwarePaginator($paginated, $collection->count(), $limit);
        }

        if (isset($filters['saved']) && $filters['saved']) {
            $queryBuilder->whereIn(
                'ReportID',
                $this->savedReportRepository->getUserSavedReportsIds(Auth::user()->id)
            );
        }
        return $queryBuilder->where('Approved', 1)->orderBy('ReportDate', 'DESC')->paginateFilter($limit);
    }

    /**
     * @param Builder $queryBuilder
     * @param int     $limit
     * @return Collection
     */
    private function getTrendingReportsCollection(Builder $queryBuilder, int $limit): Collection
    {
        $trendingReportsIds = $this->getTrendingReportsIds($limit);
        $queryBuilder->whereIn('ReportID', $trendingReportsIds)->where('Approved', 1);
        $trendingReportsOrder = [];
        foreach ($trendingReportsIds as $index => $trendingReportsId) {
            $trendingReportsOrder[$trendingReportsId] = $index;
        }

        return $queryBuilder->get()->sort(
            function (Report $report) use ($trendingReportsOrder) {
                return $trendingReportsOrder[$report->ReportID];
            }
        );
    }

    /**
     * @param int $limit
     * @return array
     */
    private function getTrendingReportsIds(int $limit): array
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
