<?php

namespace App\Hooks;

use App\Auth;
use App\Contracts\Hook;
use App\Models\ReportWeight;
use App\Models\Subscription;
use App\Services\WeightAssignationService;

class SubscribeHook implements Hook
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


    public function before(object $model): void {}

    /**
     * @param Subscription $model
     */
    public function after(object $model): void
    {
        if ($model->subscribable_type === Subscription::SECTOR_SUBSCRIPTION_TYPE)
        {
            $companiesIds = $model->subscribable->industryDetails->pluck('CompanyID')->unique()->toArray();

            $this->weightAssignationService->assignWeights(Auth::getAuthenticatedUser()->id,$companiesIds,ReportWeight::COMPANY_WEIGHT);
        }
    }
}
