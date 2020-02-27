<?php

namespace App\Factories;

use App\Transformers\CompanyTransformer;
use App\Transformers\ErrorTransformer;
use App\Transformers\MessageTransformer;
use App\Transformers\RecommendationTransformer;
use App\Transformers\RegionTransformer;
use App\Transformers\ReportTransformer;
use App\Transformers\SectorTransformer;
use App\Transformers\TokenTransformer;
use App\Transformers\UserTransformer;
use InvalidArgumentException;
use League\Fractal\TransformerAbstract;

class TransformerFactory
{
    /** @var UserTransformer $userTransformer */
    protected $userTransformer;

    /** @var ErrorTransformer $errorTransformer */
    protected $errorTransformer;

    /** @var TokenTransformer $tokenTransformer */
    protected $tokenTransformer;

    /** @var MessageTransformer $messageTransformer */
    protected $messageTransformer;

    /** @var ReportTransformer $reportTransformer */
    protected $reportTransformer;

    /** @var CompanyTransformer $companyTransformer */
    protected $companyTransformer;

    /** @var SectorTransformer $sectorTransformer */
    protected $sectorTransformer;

    /** @var RegionTransformer $regionTransformer */
    protected $regionTransformer;

    /** @var RecommendationTransformer $recommendationTransformer */
    protected $recommendationTransformer;

    /**
     * TransformerFactory constructor.
     *
     * @param UserTransformer           $userTransformer
     * @param ErrorTransformer          $errorTransformer
     * @param TokenTransformer          $tokenTransformer
     * @param MessageTransformer        $messageTransformer
     * @param ReportTransformer         $reportTransformer
     * @param CompanyTransformer        $companyTransformer
     * @param SectorTransformer         $sectorTransformer
     * @param RegionTransformer         $regionTransformer
     * @param RecommendationTransformer $recommendationTransformer
     */
    public function __construct(
        UserTransformer $userTransformer,
        ErrorTransformer $errorTransformer,
        TokenTransformer $tokenTransformer,
        MessageTransformer $messageTransformer,
        ReportTransformer $reportTransformer,
        CompanyTransformer $companyTransformer,
        SectorTransformer $sectorTransformer,
        RegionTransformer $regionTransformer,
        RecommendationTransformer $recommendationTransformer
    ) {
        $this->userTransformer           = $userTransformer;
        $this->errorTransformer          = $errorTransformer;
        $this->tokenTransformer          = $tokenTransformer;
        $this->messageTransformer        = $messageTransformer;
        $this->reportTransformer         = $reportTransformer;
        $this->companyTransformer        = $companyTransformer;
        $this->sectorTransformer         = $sectorTransformer;
        $this->regionTransformer         = $regionTransformer;
        $this->recommendationTransformer = $recommendationTransformer;
    }


    /**
     * @param string $transformer
     * @return TransformerAbstract
     */
    public function make(string $transformer): TransformerAbstract
    {

        switch ($transformer) {
            case ErrorTransformer::class:
                return $this->errorTransformer;
            case MessageTransformer::class:
                return $this->messageTransformer;
            case TokenTransformer::class:
                return $this->tokenTransformer;
            case UserTransformer::class:
                return $this->userTransformer;
            case ReportTransformer::class:
                return $this->reportTransformer;
            case CompanyTransformer::class:
                return $this->companyTransformer;
            case SectorTransformer::class:
                return $this->sectorTransformer;
            case RegionTransformer::class:
                return $this->regionTransformer;
            case RecommendationTransformer::class:
                return $this->recommendationTransformer;
            default:
                throw new InvalidArgumentException("Transformer $transformer not found");
        }
    }
}
