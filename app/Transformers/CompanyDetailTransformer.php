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
        return array_merge(
            $this->companyTransformer->transform($company),
            [
                'sector'         => $this->getSector($company) instanceof Sector ? $this->sectorTransformer->transform(
                    $this->getSector($company)
                ) : null,
                'recommendation' => $this->getRecommendation($company, $reportId) instanceof Recommendation
                    ? $this->recommendationTransformer->transform($this->getRecommendation($company, $reportId)) : null,
            ]
        );
    }

    /**
     * @param Company  $company
     * @param int|null $reportId
     * @return Recommendation|null
     */
    private function getRecommendation(Company $company, int $reportId = null): ?Recommendation
    {
        $recommendation = $company->recommendations();
        if ($reportId) {
            $recommendation->where('ReportID', $reportId);
        }

        return $recommendation->first();
    }

    /**
     * @param Company $company
     * @return Sector|null
     */
    private function getSector(Company $company): ?Sector
    {
        return optional($company->industries()->first())->sector;
    }
}
