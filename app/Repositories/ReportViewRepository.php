<?php


namespace App\Repositories;


use App\Models\ReportView;

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
}
