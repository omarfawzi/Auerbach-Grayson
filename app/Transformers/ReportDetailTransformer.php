<?php

namespace App\Transformers;

use App\Models\SQL\Company;
use App\Models\SQL\Report;
use App\Models\SQL\Sector;
use League\Fractal\TransformerAbstract;

class ReportDetailTransformer extends TransformerAbstract
{
    /** @var ReportTransformer $reportTransformer */
    protected $reportTransformer;

    /** @var CompanyTransformer $companyTransformer */
    protected $companyTransformer;

    /** @var SectorTransformer $sectorTransformer */
    protected $sectorTransformer;

    /**
     * ReportDetailTransformer constructor.
     *
     * @param ReportTransformer  $reportTransformer
     * @param CompanyTransformer $companyTransformer
     * @param SectorTransformer  $sectorTransformer
     */
    public function __construct(
        ReportTransformer $reportTransformer,
        CompanyTransformer $companyTransformer,
        SectorTransformer $sectorTransformer
    ) {
        $this->reportTransformer  = $reportTransformer;
        $this->companyTransformer = $companyTransformer;
        $this->sectorTransformer  = $sectorTransformer;
    }


    public function transform(Report $report)
    {
        return array_merge(
            $this->reportTransformer->transform($report),
            [
                'path'    => $report->FileLocation,
                'companies' => array_map(
                    function (Company $company) {
                        return $this->companyTransformer->transform($company);
                    },
                    $report->companies
                ),
                'summary' => $report->FirstLine
            ]
        );
    }
}
