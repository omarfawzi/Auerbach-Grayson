<?php

namespace App\Transformers;

use App\Models\SQL\Company;
use App\Models\SQL\Recommendation;
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

    /** @var RecommendationTransformer $recommendationTransformer */
    protected $recommendationTransformer;

    /**
     * ReportDetailTransformer constructor.
     *
     * @param ReportTransformer         $reportTransformer
     * @param CompanyTransformer        $companyTransformer
     * @param SectorTransformer         $sectorTransformer
     * @param RecommendationTransformer $recommendationTransformer
     */
    public function __construct(
        ReportTransformer $reportTransformer,
        CompanyTransformer $companyTransformer,
        SectorTransformer $sectorTransformer,
        RecommendationTransformer $recommendationTransformer
    ) {
        $this->reportTransformer         = $reportTransformer;
        $this->companyTransformer        = $companyTransformer;
        $this->sectorTransformer         = $sectorTransformer;
        $this->recommendationTransformer = $recommendationTransformer;
    }


    /**
     * @param Report $report
     * @return array
     */
    public function transform(Report $report)
    {
        return array_merge(
            $this->reportTransformer->transform($report),
            [
                'path'           => $report->FileLocation,
                'sector'         => $report->getSector() instanceof Sector ? $this->sectorTransformer->transform(
                    $report->getSector()
                ) : null,
                'company'        => $report->companies()->first() instanceof Company
                    ? $this->companyTransformer->transform(
                        $report->companies()->first()
                    ) : null,
                'recommendation' => $report->recommendations()->first() instanceof Recommendation
                    ? $this->recommendationTransformer->transform($report->recommendations()->first()) : null,
                'summary'        => $report->FirstLine,
            ]
        );
    }
}
