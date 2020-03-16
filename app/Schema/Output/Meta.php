<?php

namespace App\Schema\Output;

use OpenApi\Annotations as OA;

/**
 * Class Meta
 * @OA\Schema(description="Meta Body")
 * @package App\Schema\Output
 */
class Meta
{
    /**
     * @OA\Property(ref="#/components/schemas/Pagination")
     * @var int $total
     */
    public $pagination;
}
