<?php

namespace App\Services;

use App\Repositories\CompanyRepository;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class IPlannerService
{

    /** @var Client $guzzleClient */
    private $guzzleClient;

    /** @var CompanyRepository $companyRepository */
    private $companyRepository;

    /**
     * IPlannerService constructor.
     *
     * @param Client $guzzleClient
     */
    public function __construct(Client $guzzleClient, CompanyRepository $companyRepository)
    {
        $this->guzzleClient = $guzzleClient;
        $this->companyRepository = $companyRepository;
    }


    /**
     * @param DateTime $startDate
     * @param array    $codes
     * @return mixed
     */
    public function getEventEntities(DateTime $startDate, array $codes)
    {

        $response = $this->guzzleClient->get(
            env('IPLANNER_URL'),
            [
                'auth'                 => [
                    env('IPLANNER_USERNAME') ,
                    env('IPLANNER_PASSWORD')
                ],
                'query' =>[
                'EventStartDate' => $startDate->format('m-d-Y'),
                'EventTypeCode'        => sprintf("[%s]", implode(',', $codes)),
                '$Components'          => 'DmEventEntity,DmEventContact',
                '$format'              => 'json',
                ]
            ]
        );

        $content = json_decode($response->getBody()->getContents(), true);
        $eventEntities = [];

        if (!empty($content)) {
            $eventEntities = $this->prepareEventDetails($content);
        }

        return $eventEntities;
    }

    /**
     * @param array $events
     * @return array
     */
    private function prepareEventDetails(array $events) : array
    {
        $eventEntities = $events['DmEventEntity'];
        $contactEntities = $events['DmEventContact'];

        $companiesSymbol = array_filter(
            Arr::pluck($eventEntities, 'symbol'),
            function ($v) {
                return $v != null && $v != "";
            },
            ARRAY_FILTER_USE_BOTH
        );

        $companyEventEntitiesSymbols = $this->companyRepository->getCompaniesByCode(array_values($companiesSymbol));
        $eventCompanies = [];

        foreach($eventEntities as $entity){
            if(empty($entity['symbol']) || is_null($entity['symbol'])){
                continue;
            }

            if(!array_key_exists($entity['symbol'], $companyEventEntitiesSymbols)){
                continue;
            }
            $eventCompanies[$entity['event_id']][] = $companyEventEntitiesSymbols[$entity['symbol']];
        }
        $clientRecommendedCompanies = [];

        foreach($contactEntities as $contact){
            if(!array_key_exists($contact['event_id'], $eventCompanies)){
                continue;
            }
            if(empty($contact['ext_key_num']) || is_null($contact['ext_key_num'])){
                continue;
            }
            $clientRecommendedCompanies[$contact['ext_key_num']] = $eventCompanies[$contact['event_id']];
        }

        return $clientRecommendedCompanies;
    }
}

