<?php

namespace App\Schema\Output;
use OpenApi\Annotations as OA;

/**
 * Class ReportDetail
 * @OA\Schema(description="ReportDetail Output Description")
 * @package App\Schema\Output
 */
class ReportDetail extends Report
{
    /**
     * @OA\Property(
     *     type="string",
     *     description="Report Path"
     * )
     *
     * @var string|null $path
     */
    public $path;

    /**
     * @OA\Property(
     *     type="boolean",
     *     description="Report Saved or Not"
     * )
     *
     * @var boolean|null $isSaved
     */
    public $isSaved;

    /**
     * @OA\Property(type="array",@OA\Items(type="object",ref="#/components/schemas/CompanyDetail"))
     *
     * @var CompanyDetail[] $companies
     */
    public $companies;


    /**
     * @OA\Property(
     *     type="string",
     *     description="Report Summary"
     * )
     * @var string $summary
     */
    public $summary;

}
