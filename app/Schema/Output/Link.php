<?php

namespace App\Schema\Output;

use OpenApi\Annotations as OA;

/**
 * Class Link
 * @OA\Schema(description="Link inside pagination")
 * @package App\Schema\Output
 */
class Link
{
    /**
     * @OA\Property(
     *     type="string",
     *     description="next page",
     *     example="http://localhost:8000/api/regions?page=3"
     * )
     *
     * @var string $next
     */
    public $next;

    /**
     * @OA\Property(
     *     type="string",
     *     description="previous page",
     *     example="http://localhost:8000/api/regions?page=2"
     * )
     *
     * @var string $previous
     */
    public $previous;
}
