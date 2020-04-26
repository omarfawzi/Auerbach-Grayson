<?php

namespace App\Services;

use App\Auth;
use App\Constants\EventCodes;
use App\Models\ReportWeight;
use App\Models\Subscription;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Arr;

class WeightAssignationService
{
    /** @var IPlannerService $iplannerService */
    private $iplannerService;

    /**
     * WeightAssignationService constructor.
     *
     * @param IPlannerService $iplannerService
     */
    public function __construct(IPlannerService $iplannerService) { $this->iplannerService = $iplannerService; }

    /**
     * @throws Exception
     */
    public function assignWeights()
    {
        $userId = Auth::getAuthenticatedUser()->id;

        $client = Auth::getAuthenticatedUser()->getClient();

        $lastAssignedDate = Carbon::now()->subMonths(6)->toDateTime();

        $reportWeight     = ReportWeight::select('updated_at')->where('user_id', $userId)->orderBy('updated_at', 'desc')->first();

        if ($reportWeight instanceof ReportWeight) {
            $lastAssignedDate = new DateTime($reportWeight->updated_at);
        }

        $companyEventEntitiesIds = Arr::pluck($this->iplannerService->getEventEntities(
            $lastAssignedDate,
            [EventCodes::CONFERENCE_CODE, EventCodes::MEETING_CODE],
            $client->IPREO_ContactID
        )['DmEventEntity'],'company_id');

        $companySubscriptionsIds = Subscription::select('subscribable_id')->where(
            ['subscribable_type' => Subscription::COMPANY_SUBSCRIPTION_TYPE, 'user_id' => $userId]
        )->get()->pluck('subscribable_id')->toArray();
    }

}
