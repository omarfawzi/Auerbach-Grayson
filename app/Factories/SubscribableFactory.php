<?php

namespace App\Factories;

use App\Contracts\Subscribable;
use App\Models\SQL\Company;
use App\Models\SQL\Sector;
use App\Transformers\CompanyTransformer;
use App\Transformers\CountryTransformer;
use App\Transformers\SectorTransformer;
use League\Fractal\TransformerAbstract;

class SubscribableFactory
{
    /** @var CompanyTransformer $companyTransformer */
    protected $companyTransformer;

    /** @var SectorTransformer $sectorTransformer */
    protected $sectorTransformer;

    /** @var CountryTransformer $countryTransformer */
    protected $countryTransformer;

    /**
     * SubscribableFactory constructor.
     *
     * @param CompanyTransformer $companyTransformer
     * @param SectorTransformer  $sectorTransformer
     * @param CountryTransformer $countryTransformer
     */
    public function __construct(
        CompanyTransformer $companyTransformer,
        SectorTransformer $sectorTransformer,
        CountryTransformer $countryTransformer
    ) {
        $this->companyTransformer = $companyTransformer;
        $this->sectorTransformer  = $sectorTransformer;
        $this->countryTransformer = $countryTransformer;
    }


    /**
     * @param Subscribable $subscribable
     * @return TransformerAbstract
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
