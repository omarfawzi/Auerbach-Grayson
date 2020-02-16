<?php

namespace App\Transformers;

use App\Models\SQL\Company;
use League\Fractal\TransformerAbstract;

class CompanyTransformer extends TransformerAbstract
{
    public function transform(Company $company)
    {
        return [
            'id' => $company->CompanyID,
            'title' => $company->Company,
            'ticker' => $company->getTicker()
        ];
    }
}
