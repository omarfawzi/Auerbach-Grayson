<?php

namespace App\Transformers;

use App\Models\SQL\Company;
use App\Models\SQL\Report;
use League\Fractal\TransformerAbstract;

class ReportDetailTransformer extends TransformerAbstract
{
    /** @var ReportTransformer $reportTransformer */
    protected $reportTransformer;

    /** @var CompanyDetailTransformer $companyDetailTransformer */
    protected $companyDetailTransformer;

    /**
     * ReportDetailTransformer constructor.
     *
     * @param ReportTransformer        $reportTransformer
     * @param CompanyDetailTransformer $companyDetailTransformer
     */
    public function __construct(
        ReportTransformer $reportTransformer,
        CompanyDetailTransformer $companyDetailTransformer
    ) {
        $this->reportTransformer        = $reportTransformer;
        $this->companyDetailTransformer = $companyDetailTransformer;
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
                'companies'        => $report->companies->map(function (Company $company) use($report) {
                    return $this->companyDetailTransformer->transform($company , $report->getKey());
                }),
                'summary'        => $report->FirstLine,
            ]
        );
    }
}
