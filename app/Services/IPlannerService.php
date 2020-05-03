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
     * @param int      $clientID
     * @return mixed
     */
    //public function getEventEntities(DateTime $startDate, array $codes, int $clientID)
    public function getEventEntities(DateTime $startDate, array $codes)
    {
        //$startDate = DateTime::createFromFormat('j-M-Y', '15-Feb-2009');
        $response = $this->guzzleClient->get(
            env('IPLANNER_URL'),
            [
                'auth'                 => [
                    env('IPLANNER_USERNAME') ,
                    env('IPLANNER_PASSWORD')
                ],
                'query' =>[
                'EventStartDate_Upper' => $startDate->format('m-d-Y'),
                'EventTypeCode'        => sprintf("[%s]", implode(',', $codes)),
                '$Components'          => 'DmEventEntity','DmEventContact',
                '$format'              => 'json',
                ]
            ]
        );
        $eventEntities = $this->prepareEventDetails(json_decode($response->getBody()->getContents(), true));

        return $eventEntities;
        //return json_decode($response->getBody()->getContents(),true);
    }

    private function prepareEventDetails($arrEvents){
        if(empty($arrEvents)){
            return array();
        }

        $arrEntities = $arrEvents['DmEventEntity'];
        $arrContacts = $arrEvents['DmEventContact'];

        $arrContacts = array();
        $arrContacts[] = array('event_id'=>2047523679, 'ext_key_num'=>15381);

        $companiesSymbol = array_filter(
            Arr::pluck($arrEntities, 'symbol'),
            function($v)
            {
                return $v != null && $v != "";
            }, ARRAY_FILTER_USE_BOTH);

        $companyEventEntitiesSymbols = $this->companyRepository->getCompaniesByCode(array_values($companiesSymbol));

        $arrEventCompanies = array();
        foreach($arrEntities as $entity){
            if(!array_key_exists($entity['event_id'], $arrEventCompanies)){
                $arrEventDetails[$entity['event_id']] = array();
            }
            if(!array_key_exists($entity['symbol'], $companyEventEntitiesSymbols)){
                continue;
            }
            $arrEventCompanies[$entity['event_id']][] = $companyEventEntitiesSymbols[$entity['symbol']];
        }

        $arrClientRecommendedCompanies = array();
        foreach($arrContacts as $contact){
            if(!array_key_exists($contact['event_id'], $arrEventCompanies)){
                continue;
            }
            $arrClientRecommendedCompanies[$contact['ext_key_num']] = array();
            $arrClientRecommendedCompanies[$contact['ext_key_num']] = $arrEventCompanies[$contact['event_id']];
        }
        return $arrClientRecommendedCompanies;
    }
}

