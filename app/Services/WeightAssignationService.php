<?php

namespace App\Services;

use App\Models\ReportWeight;
use App\Models\Subscription;
use App\Repositories\ReportWeightRepository;
use App\Repositories\SubscriptionRepository;
use Carbon\Carbon;
use DateTime;
use Exception;

class WeightAssignationService
{
    /** @var ReportWeightRepository $reportWeightRepository */
    protected $reportWeightRepository;

    /** @var SubscriptionRepository $subscriptionRepository */
    protected $subscriptionRepository;

    /**
     * WeightAssignationService constructor.
     *
     * @param ReportWeightRepository $reportWeightRepository
     * @param SubscriptionRepository $subscriptionRepository
     */
    public function __construct(
        ReportWeightRepository $reportWeightRepository,
        SubscriptionRepository $subscriptionRepository
    ) {
        $this->reportWeightRepository = $reportWeightRepository;
        $this->subscriptionRepository = $subscriptionRepository;
    }


    /**
     * @param int      $userId
     * @param DateTime $lastAssignedDate
     * @param array    $eventCompaniesIds
     * @return void
     * @throws Exception
     */
    public function assign(int $userId,DateTime $lastAssignedDate ,array $eventCompaniesIds = []) : void
    {
        $reportWeight = $this->reportWeightRepository->getLastChangedUserReportWeight($userId);

        $lastAssignedDate = $reportWeight instanceof ReportWeight ? new DateTime($reportWeight->updated_at,'utc') : $lastAssignedDate;

        $companySubscriptionsIds = $this->subscriptionRepository->getUserSubscribableIdsAfter($userId,Subscription::COMPANY_SUBSCRIPTION_TYPE,$lastAssignedDate);

        if(!empty($eventCompaniesIds)){
            $this->assignWeights($userId, $eventCompaniesIds, ReportWeight::COMPANY_WEIGHT);
        }

        if(!empty($companySubscriptionsIds)){
            $this->assignWeights($userId, $companySubscriptionsIds, ReportWeight::SUBSCRIPTION_WEIGHT);
        }
    }

    /**
     * @param int   $userId
     * @param array $companyIds
     * @param int   $weight
     */
    public function assignWeights(int $userId, array $companyIds, int $weight) : void
    {
        $now = Carbon::now('utc')->toDateTimeString();

        $existingCompanyIds = $this->reportWeightRepository->getExistingCompanyIds($userId,$companyIds);

        $newCompanyIds = array_diff($companyIds, $existingCompanyIds);

        $bulkInsertData = array_map(
            function (int $newCompanyId) use ($userId, $weight, $now) {
                return [
                    'company_id' => $newCompanyId,
                    'user_id'    => $userId,
                    'weight'     => $weight,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            },
            $newCompanyIds
        );

        $this->reportWeightRepository->incrementCompaniesAndUserWeight($userId,$existingCompanyIds,$weight);

        $this->reportWeightRepository->bulkStore($bulkInsertData);
    }

}
