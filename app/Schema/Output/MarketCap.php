<?php

namespace App\Schema\Output;

use OpenApi\Annotations as OA;

/**
 * Class MarketCap
 * @OA\Schema(description="MarketCap Output Description")
 *
 * @package App\Schema\Output
 */
class MarketCap
{
    /**
     * @OA\Property(
     *     type="integer",
     *     description="ID"
     * )
     *
     * @var int $id
     */
    public $id;

    /**
     * @OA\Property(
     *     type="string",
     *     description="MarketCap Name"
     * )
     *
     * @var string $name
     */
    public $name;
}
