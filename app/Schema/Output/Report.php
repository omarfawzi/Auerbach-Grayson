<?php

namespace App\Schema\Output;

use OpenApi\Annotations as OA;

/**
 * Class Report
 * @OA\Schema(description="Report Output Description")
 * @package App\Schema\Output
 */
class Report
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
     * @OA\Property(
     *     type="string",
     *     description="Report Path"
     * )
     *
     * @var string|null $path
     */
    public $path;
}
