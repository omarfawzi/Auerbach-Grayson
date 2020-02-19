<?php

namespace App\Transformers;

use App\Dto\Output\CompanyDto;
use App\Models\SQL\Company;
use League\Fractal\TransformerAbstract;

class CompanyTransformer extends TransformerAbstract
{
    /**
     * @param Company $company
     * @return array
     */
    public function transform(Company $company): array
    {
        return (new CompanyDto($company->CompanyID, $company->Company, $company->getTicker()))->toArray();
    }
}
