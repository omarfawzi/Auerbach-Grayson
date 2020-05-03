<?php

namespace App\Factories;

use App\Contracts\Subscribable;
use App\Models\SQL\Company;
use App\Models\SQL\Sector;
use App\Transformers\CompanyTransformer;
use App\Transformers\SectorTransformer;
use League\Fractal\TransformerAbstract;

class SubscribableFactory
{
    /** @var CompanyTransformer $companyTransformer */
    protected $companyTransformer;

    /** @var SectorTransformer $sectorTransformer */
    protected $sectorTransformer;

    /**
     * SubscribableFactory constructor.
     *
     * @param CompanyTransformer $companyTransformer
     * @param SectorTransformer  $sectorTransformer
     */
    public function __construct(CompanyTransformer $companyTransformer, SectorTransformer $sectorTransformer)
    {
        $this->companyTransformer = $companyTransformer;
        $this->sectorTransformer  = $sectorTransformer;
    }


    /**
     * @param Subscribable $subscribable
     * @return array
     */
    public function make(Subscribable $subscribable) : TransformerAbstract
    {
        switch (true) {
            case $subscribable instanceof Company:
                return $this->companyTransformer;
            case $subscribable instanceof Sector:
                return $this->sectorTransformer;
            default:
                throw new \InvalidArgumentException("$subscribable is not valid Subscribable");
        }
    }
}
