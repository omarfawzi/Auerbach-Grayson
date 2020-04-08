<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;

class SavedReportValidator
{
    /**
     * @param int $reportId
     * @param int $userId
     */
    public function validate(int $reportId , int $userId)
    {
        $validator = Validator::make(
            [
                'report_id' => $reportId,
                'user_id' => $userId
            ],
            [
                'report_id' => "unique:saved_reports,report_id,NULL,id,user_id,$userId",
                'user_id' => "unique:saved_reports,user_id,NULL,id,report_id,$reportId"
            ]
        );
        $validator->validate();
    }
}
