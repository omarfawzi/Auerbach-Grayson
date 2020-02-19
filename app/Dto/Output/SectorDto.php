<?php

namespace App\Dto\Output;

use App\Dto\Dto;
use OpenApi\Annotations as OA;

/**
 * Class SectorDto
 * @OA\Schema(description="Sector Output Description")
 * @package App\Dto\Output
 */
class SectorDto extends Dto
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
     *     description= "Sector Name"
     * )
     *
     * @var string $name
     */
    public $name;

    /**
     * SectorDto constructor.
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
