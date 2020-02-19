<?php

namespace App\Dto\Output;

use App\Dto\Dto;

use OpenApi\Annotations as OA;

/**
 * Class CompanyDto
 * @OA\Schema(description="Company Output Description")
 * @package App\Dto\Output
 */

class CompanyDto extends Dto
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
     *     description="Company Title"
     * )
     *
     * @var string $title
     */
    public $title;

    /**
     * @OA\Property(
     *     type="string",
     *     description="Company Ticker"
     * )
     *
     * @var string $ticker
     */
    public $ticker;

    /**
     * CompanyDto constructor.
     *
     * @param int    $id
     * @param string $title
     * @param string $ticker
     */
    public function __construct(int $id, string $title, string $ticker)
    {
        $this->id     = $id;
        $this->title  = $title;
        $this->ticker = $ticker;
    }


}
