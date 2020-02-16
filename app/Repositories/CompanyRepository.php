<?php

namespace App\Repositories;

use App\Models\SQL\Company;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyRepository
{
    /**
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getCompanies(int $limit) : LengthAwarePaginator
    {
        return Company::paginate($limit);
    }
}
