<?php

namespace App\Factories;

use App\Transformers\CompanyTransformer;
use App\Transformers\ErrorTransformer;
use App\Transformers\MessageTransformer;
use App\Transformers\RecommendationTransformer;
use App\Transformers\RegionTransformer;
use App\Transformers\ReportDetailTransformer;
use App\Transformers\ReportTransformer;
use App\Transformers\SectorTransformer;
use App\Transformers\SubscriptionTransformer;
use App\Transformers\TokenTransformer;
use App\Transformers\TypeTransformer;
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

    /** @var SubscriptionTransformer $subscriptionTransformer */
    protected $subscriptionTransformer;

    /** @var TypeTransformer $typeTransformer */
    protected $typeTransformer;

    /** @var ReportDetailTransformer $reportDetailTransformer */
    protected $reportDetailTransformer;

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
     * @param SubscriptionTransformer   $subscriptionTransformer
     * @param TypeTransformer           $typeTransformer
     * @param ReportDetailTransformer   $reportDetailTransformer
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
        RecommendationTransformer $recommendationTransformer,
        SubscriptionTransformer $subscriptionTransformer,
        TypeTransformer $typeTransformer,
        ReportDetailTransformer $reportDetailTransformer
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
        $this->subscriptionTransformer   = $subscriptionTransformer;
        $this->typeTransformer           = $typeTransformer;
        $this->reportDetailTransformer   = $reportDetailTransformer;
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
            case SubscriptionTransformer::class:
                return $this->subscriptionTransformer;
            case TypeTransformer::class:
                return $this->typeTransformer;
            case ReportDetailTransformer::class:
                return $this->reportDetailTransformer;
            default:
                throw new InvalidArgumentException("Transformer $transformer not found");
        }
    }
}
