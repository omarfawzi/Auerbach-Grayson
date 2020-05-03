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
     * @OA\Property(
     *     type="integer",
     *     description="PHP Price"
     * )
     *
     * @var float $price
     */
    public $price;

    /**
     * @OA\Property(ref="#/components/schemas/Industry")
     *
     * @var Industry $industry
     */
    public $industry;

    /**
     * @OA\Property(ref="#/components/schemas/MarketCap")
     *
     * @var MarketCap $industry
     */
    public $marketCap;

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

