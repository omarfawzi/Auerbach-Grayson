<?php

namespace App\Transformers;

use App\Models\SQL\Company;
use App\Models\SQL\Recommendation;
use App\Models\SQL\Sector;
use League\Fractal\TransformerAbstract;

class CompanyDetailTransformer extends TransformerAbstract
{
    /** @var CompanyTransformer $companyTransformer */
    protected $companyTransformer;

    /** @var SectorTransformer $sectorTransformer */
    protected $sectorTransformer;

    /** @var RecommendationTransformer $recommendationTransformer */
    protected $recommendationTransformer;

    /**
     * CompanyDetailTransformer constructor.
     *
     * @param CompanyTransformer        $companyTransformer
     * @param SectorTransformer         $sectorTransformer
     * @param RecommendationTransformer $recommendationTransformer
     */
    public function __construct(
        CompanyTransformer $companyTransformer,
        SectorTransformer $sectorTransformer,
        RecommendationTransformer $recommendationTransformer
    ) {
        $this->companyTransformer        = $companyTransformer;
        $this->sectorTransformer         = $sectorTransformer;
        $this->recommendationTransformer = $recommendationTransformer;
    }


    /**
     * @param Company  $company
     * @param int|null $reportId
     * @return array
     */
    public function transform(Company $company, int $reportId = null)
    {
        $sector         = optional($company->industries()->first())->sector;
        $recommendation = $company->recommendations()->where('ReportID', $reportId)->first();

        return array_merge(
            $this->companyTransformer->transform($company),
            [
                'sector'         => $sector instanceof Sector ? $this->sectorTransformer->transform($sector) : null,
                'recommendation' => $recommendation instanceof Recommendation ? $this->recommendationTransformer->transform($recommendation) : null
            ]
        );
    }
}
