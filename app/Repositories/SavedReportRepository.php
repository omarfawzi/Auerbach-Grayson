<?php

namespace App\Repositories;

use App\Models\SavedReport;

class SavedReportRepository
{
    /**
     * @param int $reportId
     * @param int $userId
     * @return bool
     */
    public function saveReport(int $reportId, int $userId)
    {
        $savedReport = new SavedReport();
        $savedReport->report_id = $reportId;
        $savedReport->user_id = $userId;
        return $savedReport->save();
    }

    /**
     * @param int $reportId
     * @param int $userId
     * @return void
     */
    public function deleteReport(int $reportId, int $userId) : void
    {
        SavedReport::where(['report_id'=>$reportId,'user_id'=>$userId])->delete();
    }

    /**
     * @param int $userId
     * @return int[]
     */
    public function getUserSavedReportsIds(int $userId) : array
    {
        return SavedReport::select('report_id')->where('user_id',$userId)->get()->pluck('report_id')->toArray();
    }
}
