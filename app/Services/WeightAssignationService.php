<?php

namespace App\Services;

use App\Auth;
use App\Constants\EventCodes;
use App\Models\ReportWeight;
use Carbon\Carbon;
use DateTime;
use Exception;

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
     * @param int $userId
     * @throws Exception
     */
    public function assignWeights(int $userId)
    {
        $client = Auth::getAuthenticatedUser()->getClient();

        $lastAssignedDate = Carbon::now()->subMonths(6)->toDateTime();

        $reportWeight     = ReportWeight::select('updated_at')->where('user_id', $userId)->orderBy('updated_at', 'desc')->first();

        if ($reportWeight instanceof ReportWeight) {
            $lastAssignedDate = new DateTime($reportWeight->updated_at);
        }

        $eventEntities = $this->iplannerService->getEventEntities(
            $lastAssignedDate,
            [EventCodes::CONFERENCE_CODE, EventCodes::MEETING_CODE],
            $client->IPREO_ContactID
        );
    }

}
