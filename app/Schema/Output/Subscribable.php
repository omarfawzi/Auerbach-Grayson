<?php


namespace App\Schema\Output;

use OpenApi\Annotations as OA;

/**
 * Class Subscribable
 * @OA\Schema(description="Subscribable Output Description")
 * @package App\Schema\Output
 */
class Subscribable
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
     *     description="Subscribable Name"
     * )
     *
     * @var string $name
     */
    public $name;
}
