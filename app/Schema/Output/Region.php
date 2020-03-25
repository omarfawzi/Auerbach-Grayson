<?php

namespace App\Schema\Output;

use OpenApi\Annotations as OA;

/**
 * Class Region
 * @OA\Schema(description="Region Output Description")
 * @package App\Schema\Output
 */
class Region
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
     *     description= "Region Name"
     * )
     *
     * @var string $name
     */
    public $name;
}
