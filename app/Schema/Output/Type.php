<?php

namespace App\Schema\Output;

use OpenApi\Annotations as OA;

/**
 * Class Type
 * @OA\Schema(description="Type Output Description")
 * @package App\Schema\Output
 */
class Type
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
     *     description= "Type Name"
     * )
     *
     * @var string $name
     */
    public $name;
}
