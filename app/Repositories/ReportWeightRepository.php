<?php

namespace App\Repositories;

use App\Auth;
use App\Models\ReportWeight;
use App\Models\SQL\Company;
use App\Models\SQL\Sector;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ReportWeightRepository
{

    /**
     * @param int $limit
     * @param int $page
     * @param string $order
     * @return array
     */
    private function getRelatedSectorCompanies(array $searchKeys, string $type){
        if(empty($searchKeys)){
            return array();
        }

        if($type == 'company'){

            $sectors = Sector::query()->select('GICS_Sector.GICS_Sector')
                ->join(
                    'Industry',
                    'Industry.GICS_SectorId',
                    '=',
                    'GICS_Sector.GICS_SectorId'

                )->join(
                    'IndustryDetail',
                    'IndustryDetail.IndustryID',
                    '=',
                    'Industry.IndustryID'

                )->join(
                    'Company',
                    'Company.CompanyID',
                    '=',
                    'IndustryDetail.CompanyID')
                ->whereIn('Company.Company', $searchKeys)->pluck('GICS_Sector')->toArray();
        }else{
            $sectors = $searchKeys;
        }

        $companiesID = array();
        if(!empty($sectors)){
           $companiesID =  Company::query()->select('Company.CompanyID')
               ->join(
                   'IndustryDetail',
                   'IndustryDetail.CompanyID',
                   '=',
                   'Company.CompanyID'
               )->join(
                   'Industry',
                   'Industry.IndustryID',
                   '=',
                   'IndustryDetail.IndustryID'
               )->join(
                   'GICS_Sector',
                   'GICS_Sector.GICS_SectorId',
                   '=',
                   'Industry.GICS_SectorId'
               )->whereIn('GICS_Sector.GICS_Sector', $sectors)->pluck('CompanyID')->toArray();
       }
        return $companiesID;
    }
     public function getWeightedCompanyIds(int $limit = 10 , int $page = 0 ,$searchKeys = array(), string $searchType = 'company'): array
     {
         $relatedCompaniesIDs = array();
         if(!empty($searchKeys)){
             $relatedCompaniesIDs = $this->getRelatedSectorCompanies($searchKeys, $searchType);
         }

         $userId = Auth::getAuthenticatedUser()->id;

         $query = ReportWeight::query();
         $query->select('company_id');
         $query->where('user_id',$userId);
         if(!empty($relatedCompaniesIDs)){
             $query->whereIn('company_id', $relatedCompaniesIDs);
         }
         $query->orderBy('weight', 'desc');
         $query->groupBy('company_id');
         $query->skip($page * $limit);
         $query->take($limit);

         return $query->get()->pluck('company_id')->toArray();

         /*return ReportWeight::query()->select('company_id')
             ->where('user_id',$userId)New
             ->orderBy('weight', $order)
             ->groupBy('company_id')
             ->skip($page * $limit)
             ->take($limit)
             ->get()->pluck('company_id')->toArray();*/
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
        ReportWeight::query()->where('user_id', $userId)
            ->whereIn('company_id', $companyIds)
            ->where('weight','>',0)
            ->decrement('weight', $step, ['updated_at' => Carbon::now()]);

        return ReportWeight::query()->where('user_id', $userId)
            ->where('weight', '<=', 0)
            ->delete();
    }
}
