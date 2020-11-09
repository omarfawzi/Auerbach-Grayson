<?php

namespace App\Transformers;

use App\Models\SavedReport;
use App\Models\SQL\Company;
use App\Models\SQL\Country;
use App\Models\SQL\Report;
use App\Repositories\ClientRepository;
use League\Fractal\TransformerAbstract;

class ReportDetailTransformer extends TransformerAbstract
{
    /** @var ReportTransformer $reportTransformer */
    protected $reportTransformer;

    /** @var CompanyDetailTransformer $companyDetailTransformer */
    protected $companyDetailTransformer;

    /** CountryTransformer $countryTransformer */
    protected $countryTransformer;

    public function __construct(
        ReportTransformer $reportTransformer,
        CompanyDetailTransformer $companyDetailTransformer,
        CountryTransformer $countryTransformer,
        ClientRepository $clientRepository
    ) {
        $this->reportTransformer        = $reportTransformer;
        $this->companyDetailTransformer = $companyDetailTransformer;
        $this->countryTransformer       = $countryTransformer;
        $this->clientRepository       = $clientRepository;
    }

    /**
     * @param Report $report
     * @return array
     */
    public function transform(Report $report)
    {
        $client = $this->clientRepository->getClientByEmail(app('auth')->user()->email);
        return array_merge(
            $this->reportTransformer->transform($report),
            [
                'path'      => env('REPORT_FETCH_URL').'?'.http_build_query(
                        [
                            'R' => $report->getKey(),
                            'S' => 'PORT',
                            'F' => 'PDF',
                            'C' => $client->ClientID
                        ]
                ),
                'isSaved'   => $report->isSaved instanceof SavedReport ? true : false,
                'countries' => $report->countries->map(
                    function (Country $country) {
                        return $this->countryTransformer->transform($country);
                    }
                ),
                'companies' => $report->companies->map(
                    function (Company $company) use ($report) {
                        return $this->companyDetailTransformer->transform($company, $report->getKey());
                    }
                ),
                'summary'   => $report->FirstLine,
            ]
        );
    }
}
