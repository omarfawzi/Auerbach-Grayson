<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * Class Meta
 * @OA\Schema(description="Meta Body")
 * @package App\Schema
 */
class Meta
{
    /**
     *
     * @OA\Property(ref="#/components/schemas/Pagination")
     * @var int $total
     */
    public $pagination;
}
