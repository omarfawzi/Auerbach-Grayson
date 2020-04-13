<?php

namespace App\Transformers;

use App\Models\SQL\Company;
use App\Models\SQL\Industry;
use App\Models\SQL\MarketCap;
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

    /** @var IndustryTransformer $industryTransformer */
    protected $industryTransformer;

    /** @var MarketCapTransformer $marketCapTranformer */
    protected $marketCapTranformer;

    /**
     * CompanyDetailTransformer constructor.
     *
     * @param CompanyTransformer        $companyTransformer
     * @param SectorTransformer         $sectorTransformer
     * @param RecommendationTransformer $recommendationTransformer
     * @param IndustryTransformer       $industryTransformer
     * @param MarketCapTransformer      $marketCapTransformer
     */
    public function __construct(
        CompanyTransformer $companyTransformer,
        SectorTransformer $sectorTransformer,
        RecommendationTransformer $recommendationTransformer,
        IndustryTransformer $industryTransformer,
        MarketCapTransformer $marketCapTransformer
    ) {
        $this->companyTransformer        = $companyTransformer;
        $this->sectorTransformer         = $sectorTransformer;
        $this->recommendationTransformer = $recommendationTransformer;
        $this->industryTransformer       = $industryTransformer;
        $this->marketCapTranformer       = $marketCapTransformer;
    }


    /**
     * @param Company $company
     * @param int     $reportId
     * @return array
     */
    public function transform(Company $company, int $reportId)
    {
        return array_merge(
            $this->companyTransformer->transform($company),
            [
                'price'          => $this->getPHPPrice($company, $reportId),
                'industry'       => $company->industry instanceof Industry ? $this->industryTransformer->transform(
                    $company->industry
                ) : null,
                'marketCap'      => $company->marketCap instanceof MarketCap ? $this->marketCapTranformer->transform(
                    $company->marketCap
                ) : null,
                'sector'         => optional($company->industry)->sector instanceof Sector ? $this->sectorTransformer->transform(
                    $company->industry->sector
                ) : null,
                'recommendation' => $this->getRecommendation($company, $reportId) instanceof Recommendation
                    ? $this->recommendationTransformer->transform($this->getRecommendation($company, $reportId)) : null,
            ]
        );
    }

    /**
     * @param Company $company
     * @param int     $reportId
     * @return float
     */
    private function getPHPPrice(Company $company, int $reportId): float
    {
        return $company->detail()->where('ReportID', $reportId)->first()->Price;
    }

    /**
     * @param Company $company
     * @param int     $reportId
     * @return Recommendation|null
     */
    private function getRecommendation(Company $company, int $reportId): ?Recommendation
    {
        return $company->recommendation()->where('ReportID', $reportId)->first();
    }
}
