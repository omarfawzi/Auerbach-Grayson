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
}
