<?php

namespace App\Hooks;

use App\Auth;
use App\Contracts\SubscriptionHook;
use App\Models\ReportWeight;
use App\Models\Subscription;
use App\Services\WeightAssignationService;

class SubscribeHook implements SubscriptionHook
{
    /** @var WeightAssignationService $weightAssignationService */
    protected $weightAssignationService;

    /**
     * SubscribeHook constructor.
     *
     * @param WeightAssignationService $weightAssignationService
     */
    public function __construct(WeightAssignationService $weightAssignationService)
    {
        $this->weightAssignationService = $weightAssignationService;
    }

    public function hook(Subscription $subscription): void
    {
        if ($subscription->subscribable_type === Subscription::SECTOR_SUBSCRIPTION_TYPE) {
            $companiesIds = $subscription->subscribable->industryDetails->pluck('CompanyID')->unique()->toArray();
            $this->weightAssignationService->assignWeights(
                Auth::getAuthenticatedUser()->id,
                $companiesIds,
                ReportWeight::SUBSCRIPTION_WEIGHT
            );
        }
    }
}
