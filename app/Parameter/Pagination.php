<?php

namespace App\Parameter;

use OpenApi\Annotations as OA;

/**
 * Class Pagination
 * @OA\Schema(description="Pagination Default Parameters")
 * @package App\Parameter
 */
class Pagination
{
    /**
     * @OA\Property(
     *     type="number",
     *     description="limit",
     *     example=20
     * )
     *
     * @var int $limit
     */
    public $limit;

    /**
     * @OA\Property(
     *     type="number",
     *     description="page",
     *     example=1
     * )
     *
     * @var int $page
     */
    public $page;
}
