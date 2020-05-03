<?php

namespace App\Services;

use App\Auth;
use App\Constants\EventCodes;
use App\Models\ReportWeight;
use App\Models\Subscription;
use App\User;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Arr;

class WeightAssignationService
{

    /**
     * WeightAssignationService constructor.
     *
     */
    public function __construct() {}

    /**
     * @throws Exception
     */
    public function assign($userId, $lastAssignedDate, $eventCompanies = array())
    {
        $reportWeight = ReportWeight::select('updated_at')->where('user_id', $userId)->orderBy('updated_at', 'desc')->first();
        if ($reportWeight instanceof ReportWeight) {
            $lastAssignedDate = new DateTime($reportWeight->updated_at,'utc');
        }

        $companySubscriptionsIds = Subscription::select('subscribable_id')
            ->where('subscribable_type', Subscription::COMPANY_SUBSCRIPTION_TYPE)
            ->where('user_id', $userId)
            ->where('created_at', ">", $lastAssignedDate)->get()->pluck('subscribable_id')->toArray();

        if(!empty($eventCompanies)){
            $this->assignWeights($userId, $eventCompanies, 2);
        }
        if(!empty($companySubscriptionsIds)){
            $this->assignWeights($userId, $companySubscriptionsIds, 1);
        }
        return true;
    }

    private function assignWeights(int $userId, array $companyIds, int $weight) : void
    {
        $now = Carbon::now('utc')->toDateTimeString();
        $existingCompanyIds = ReportWeight::whereIn('company_id', $companyIds)->where('user_id', $userId)->pluck(
            'company_id'
        )->toArray();

        $newCompanyIds = array_diff($companyIds, $existingCompanyIds);

        $bulkInsertData = [];
        foreach ($newCompanyIds as $newCompanyId) {
            $bulkInsertData[] = [
                'company_id' => $newCompanyId,
                'user_id'    => $userId,
                'weight'     => $weight,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        ReportWeight::where('user_id', $userId)->whereIn('company_id', $existingCompanyIds)->increment('weight', $weight, ['updated_at' => Carbon::now()]);
        ReportWeight::insert($bulkInsertData);

    }

}
