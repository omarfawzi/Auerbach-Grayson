<?php

namespace App\Repositories;

use App\Models\SQL\Company;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyRepository
{
    public function getCompanies(int $limit = 5) : LengthAwarePaginator
    {
        return Company::paginate($limit);
    }
}
