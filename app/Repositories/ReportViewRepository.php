<?php


namespace App\Repositories;


use App\Factories\DateFactory;
use App\Models\ReportView;
use Illuminate\Support\Facades\DB;

class ReportViewRepository
{
    /**
     * @param int $userId
     * @param int $reportId
     * @return ReportView
     */
    public function store(int $userId , int $reportId) : ReportView
    {
        $reportView = new ReportView();
        $reportView->report_id = $reportId;
        $reportView->user_id = $userId;
        $reportView->save();
        return $reportView;
    }

    /**
     * @param int $limit
     * @return array
     */
    public static function getTrendingReportsIds(int $limit): array
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
