<?php

namespace App\Dto\Output;

use App\Dto\Dto;
use OpenApi\Annotations as OA;

/**
 * Class RegionDto
 * @OA\Schema(description="Region Output Description")
 * @package App\Dto\Output
 */
class RegionDto extends Dto
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
     *     description= "Region Name"
     * )
     *
     * @var string $name
     */
    public $name;

    /**
     * RegionDto constructor.
     *
     * @param int    $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }
}
