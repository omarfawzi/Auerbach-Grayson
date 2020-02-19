<?php

namespace App\Dto\Output;

use App\Dto\Dto;
use OpenApi\Annotations as OA;

/**
 * Class ReportDto
 * @OA\Schema(description="Report Output Description")
 * @package App\Dto\Output
 */
class ReportDto extends Dto
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
     *     description= "Report Title"
     * )
     *
     * @var string|null $title
     */
    public $title;

    /**
     * @OA\Property(
     *     type="string",
     *     description= "Report Description"
     * )
     *
     * @var string|null $synopsis
     */
    public $synopsis;

    /**
     * @OA\Property(
     *     type="string",
     *     description= "Report Date"
     * )
     *
     * @var string|null $date
     */
    public $date;

    /**
     * @OA\Property(
     *     type="integer",
     *     description="Report Number of Pages"
     * )
     *
     * @var int|null $pages
     */
    public $pages;

    /**
     * @OA\Property(
     *     type="string",
     *     description="Report Analyst"
     * )
     *
     * @var string|null $analyst
     */
    public $analyst;

    /**
     * @OA\Property(
     *     type="string",
     *     description="Report Type"
     * )
     *
     * @var string|null $type
     */
    public $type;

    /**
     * ReportDto constructor.
     *
     * @param int         $id
     * @param string|null $title
     * @param string|null $synopsis
     * @param string|null $date
     * @param int|null    $pages
     * @param string|null $analyst
     * @param string|null $type
     */
    public function __construct(
        int $id,
        ?string $title,
        ?string $synopsis,
        ?string $date,
        ?int $pages,
        ?string $analyst,
        ?string $type
    ) {
        $this->id       = $id;
        $this->title    = $title;
        $this->synopsis = $synopsis;
        $this->date     = $date;
        $this->pages    = $pages;
        $this->analyst  = $analyst;
        $this->type     = $type;
    }


}
