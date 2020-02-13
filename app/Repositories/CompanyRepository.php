<?php

namespace App\Repositories;

use App\Models\SQL\Company;

class CompanyRepository
{
    public function getCompanies(int $limit = 5, int $page = -1)
    {
        return Company::skip($limit * ($page - 1))->limit($limit)->get()->all();
    }
}
