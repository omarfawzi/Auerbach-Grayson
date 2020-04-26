<?php

namespace App\Services;

use DateTime;
use GuzzleHttp\Client;

class IPlannerService
{

    /** @var Client $guzzleClient */
    private $guzzleClient;

    /**
     * IPlannerService constructor.
     *
     * @param Client $guzzleClient
     */
    public function __construct(Client $guzzleClient) { $this->guzzleClient = $guzzleClient; }


    /**
     * @param DateTime $startDate
     * @param array    $codes
     * @param int      $clientID
     * @return mixed
     */
    public function getEventEntities(DateTime $startDate, array $codes, int $clientID)
    {
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
                '$Components'          => 'DmEventEntity',
                '$format'              => 'json',
                'ext_key_num'          => $clientID,
                ]
            ]
        );
        return json_decode($response->getBody()->getContents(),true);
    }
}
