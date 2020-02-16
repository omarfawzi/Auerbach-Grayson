<?php

namespace App\Factories;

use App\Transformers\CompanyTransformer;
use App\Transformers\ErrorTransformer;
use App\Transformers\MessageTransformer;
use App\Transformers\ReportTransformer;
use App\Transformers\TokenTransformer;
use App\Transformers\UserTransformer;
use InvalidArgumentException;
use League\Fractal\TransformerAbstract;

class TransformerFactory
{
    /** @var UserTransformer $userTransformer */
    private $userTransformer;

    /** @var ErrorTransformer $errorTransformer */
    private $errorTransformer;

    /** @var TokenTransformer $tokenTransformer */
    private $tokenTransformer;

    /** @var MessageTransformer $messageTransformer */
    private $messageTransformer;

    /** @var ReportTransformer $reportTransformer */
    private $reportTransformer;

    /** @var CompanyTransformer $companyTransformer */
    private $companyTransformer;

    /**
     * TransformerFactory constructor.
     *
     * @param UserTransformer    $userTransformer
     * @param ErrorTransformer   $errorTransformer
     * @param TokenTransformer   $tokenTransformer
     * @param MessageTransformer $messageTransformer
     * @param ReportTransformer  $reportTransformer
     * @param CompanyTransformer $companyTransformer
     */
    public function __construct(
        UserTransformer $userTransformer,
        ErrorTransformer $errorTransformer,
        TokenTransformer $tokenTransformer,
        MessageTransformer $messageTransformer,
        ReportTransformer $reportTransformer,
        CompanyTransformer $companyTransformer
    ) {
        $this->userTransformer    = $userTransformer;
        $this->errorTransformer   = $errorTransformer;
        $this->tokenTransformer   = $tokenTransformer;
        $this->messageTransformer = $messageTransformer;
        $this->reportTransformer  = $reportTransformer;
        $this->companyTransformer = $companyTransformer;
    }


    /**
     * @param string $transformer
     * @return TransformerAbstract
     */
    public function make(string $transformer) : TransformerAbstract
    {
        switch ($transformer)
        {
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
            default:
                throw new InvalidArgumentException("Transformer $transformer not found");
        }
    }
}
