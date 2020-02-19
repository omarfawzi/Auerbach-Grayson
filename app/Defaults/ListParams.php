<?php

namespace App\Defaults;

use OpenApi\Annotations as OA;

/**
 * Class ListParams
 * @OA\Schema(description="Default Parameters For List View")
 * @package App\Defaults
 */
class ListParams
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
