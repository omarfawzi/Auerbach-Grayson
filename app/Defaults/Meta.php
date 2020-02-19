<?php

namespace App\Defaults;

use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * Class Meta
 * @OA\Schema(description="Meta Body")
 * @package App\Defaults
 */
class Meta extends JsonResponse
{
    /**
     *
     * @OA\Property(ref="#/components/schemas/Pagination")
     * @var int $total
     */
    public $pagination;
}
