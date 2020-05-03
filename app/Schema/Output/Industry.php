<?php

namespace App\Schema\Output;

use OpenApi\Annotations as OA;

/**
 * Class Industry
 * @OA\Schema(description="Industry Output Description")
 *
 * @package App\Schema\Output
 */
class Industry
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
     *     description="Industry Name"
     * )
     *
     * @var string $name
     */
    public $name;
}
