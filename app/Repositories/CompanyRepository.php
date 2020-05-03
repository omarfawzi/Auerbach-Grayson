<?php

namespace App\Repositories;

use App\Models\SQL\Company;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyRepository
{
    /**
     * @param int   $limit
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getCompanies(int $limit , array $filters = []) : LengthAwarePaginator
    {
        return Company::filter($filters)->paginate($limit);
    }

    public function getCompaniesByCode(array $companiesCode)
    {
        $companies = Company::whereIn('Bloomberg', $companiesCode)->get();

        $companyIDs = array();
        if(!empty($companies)){
            foreach($companies as $company){
                $companyIDs[$company->Bloomberg] = $company->CompanyID;
            }
        }
        return $companyIDs;
    }
}
