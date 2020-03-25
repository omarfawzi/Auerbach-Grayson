<?php

namespace App\Schema\Output;

use OpenApi\Annotations as OA;

/**
 * Class Company
 * @OA\Schema(description="Company Output Description")
 *
 * @package App\Schema\Output
 */
class Company
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
     *     description="Company Name"
     * )
     *
     * @var string $name
     */
    public $name;

    /**
     * @OA\Property(
     *     type="string",
     *     description="Company Ticker"
     * )
     *
     * @var string $ticker
     */
    public $ticker;
}
