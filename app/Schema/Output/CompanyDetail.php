<?php

namespace App\Schema\Output;

use OpenApi\Annotations as OA;

/**
 * Class CompanyDetail
 * @OA\Schema(description="Company Detail Output Description")
 *
 * @package App\Schema\Output
 */
class CompanyDetail extends Company
{
    /**
     * @OA\Property(ref="#/components/schemas/Sector")
     *
     * @var Sector $sector
     */
    public $sector;

    /**
     * @OA\Property(ref="#/components/schemas/Recommendation")
     *
     * @var Recommendation $recommendation
     */
    public $recommendation;
}

