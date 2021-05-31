<?php

namespace App\Hooks;

use App\Auth;
use App\Contracts\SubscriptionHook;
use App\Models\ReportWeight;
use App\Models\Subscription;
use App\Repositories\ReportWeightRepository;

class UnsubscribeHook implements SubscriptionHook
{
    /** @var ReportWeightRepository $reportWeightRepository */
    protected $reportWeightRepository;

    /**
     * UnsubscribeHook constructor.
     *
     * @param ReportWeightRepository $reportWeightRepository
     */
    public function __construct(ReportWeightRepository $reportWeightRepository)
    {
        $this->reportWeightRepository = $reportWeightRepository;
    }


    public function hook(Subscription $subscription): void
    {
        $companiesIds = [];
        if ($subscription->subscribable_type === Subscription::SECTOR_SUBSCRIPTION_TYPE) {
            $companiesIds = $subscription->subscribable->industryDetails->pluck('CompanyID')->unique()->toArray();
        }
        if ($subscription->subscribable_type === Subscription::COMPANY_SUBSCRIPTION_TYPE) {
            $companiesIds = [$subscription->subscribable_id];
        }
        if (!empty($companiesIds)) {
            $this->reportWeightRepository->decrementCompaniesAndUserWeight(
                $subscription->user_id,
                $companiesIds,
                ReportWeight::SUBSCRIPTION_WEIGHT
            );
        }
    }
}
