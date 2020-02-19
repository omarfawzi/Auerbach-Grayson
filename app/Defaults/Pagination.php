<?php

namespace App\Defaults;

use OpenApi\Annotations as OA;

/**
 * Class Pagination
 * @OA\Schema(description="Pagination Body")
 * @package App\Defaults
 */
class Pagination
{
    /**
     * @OA\Property(
     *     type="number",
     *     description="total",
     *     example=100
     * )
     *
     * @var int $total
     */
    public $total;

    /**
     * @OA\Property(
     *     type="number",
     *     description="Count of current page",
     *     example=20
     * )
     *
     * @var int $count
     */
    public $count;

    /**
     * @OA\Property(
     *     type="number",
     *     property="per_page",
     *     description="Limit of request",
     *     example=20
     * )
     *
     * @var int $perPage
     */
    public $perPage;

    /**
     * @OA\Property(
     *     type="number",
     *     property="current_page",
     *     description="Number of current page",
     *     example=1
     * )
     *
     * @var int $currentPage
     */
    public $currentPage;

    /**
     * @OA\Property(
     *     type="number",
     *     property="total_pages",
     *     description="Number of total pages",
     *     example=5
     * )
     *
     * @var int $totalPages
     */
    public $totalPages;

    /**
     * @var object
     * @OA\Property(ref="#/components/schemas/Link")
     */
    public $links;
}
