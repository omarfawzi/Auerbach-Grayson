<?php

namespace App\Repositories;

use App\Auth;
use App\Models\ReportWeight;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ReportWeightRepository
{

    /**
      * @param string $order
      * @return array
      */
     public function getWeightedCompanyIds(string $order = 'desc'): array
     {
         $userId = Auth::getAuthenticatedUser()->id;

         return ReportWeight::query()->select('company_id')
             ->where('user_id',$userId)
             ->orderBy('weight', $order)
             ->groupBy('company_id')->get()->pluck('company_id')->toArray();
     }


    /**
     * @param int $userId
     * @return ReportWeight|null
     */


    public function getLastChangedUserReportWeight(int $userId) : ?Model
    {
        return ReportWeight::query()->select('updated_at')
            ->where('user_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->first();
    }

    /**
     * @param int   $userId
     * @param array $companyIds
     * @return array
     */
    public function getExistingCompanyIds(int $userId , array $companyIds) : array
    {
        return ReportWeight::query()->whereIn('company_id', $companyIds)
            ->where('user_id', $userId)
            ->pluck('company_id')->toArray();
    }

    /**
     * @param int   $userId
     * @param array $companyIds
     * @param int   $step
     * @return int
     */
    public function incrementCompaniesAndUserWeight(int $userId , array $companyIds , int $step)
    {
        return ReportWeight::query()->where('user_id', $userId)
            ->whereIn('company_id', $companyIds)
            ->increment('weight', $step, ['updated_at' => Carbon::now()]);
    }

    /**
     * @param array $bulkData
     */
    public function bulkStore(array $bulkData) : void
    {
        ReportWeight::query()->insert($bulkData);
    }

    /**
     * @param int   $userId
     * @param array $companyIds
     * @param int   $step
     * @return int
     */
    public function decrementCompaniesAndUserWeight(int $userId , array $companyIds , int $step)
    {
        return ReportWeight::query()->where('user_id', $userId)
            ->whereIn('company_id', $companyIds)
            ->where('weight','>',0)
            ->increment('weight', $step, ['updated_at' => Carbon::now()]);
    }
}
