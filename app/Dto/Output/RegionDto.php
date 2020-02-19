<?php

namespace App\Dto\Output;

use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * Class RegionDto
 * @OA\Schema(description="Region Output Description")
 * @package App\Dto\Output
 */
class RegionDto extends JsonResponse
{
    /**
     * @OA\Property(
     *     type="integer",
     *     description="ID"
     * )
     *
     * @var int $id
     */
    public $id = 0;

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
