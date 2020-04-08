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
}
