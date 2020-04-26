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
    public function assign()
    {
        $userId = Auth::getAuthenticatedUser()->id;
        $client = Auth::getAuthenticatedUser()->getClient();

        $lastAssignedDate = Carbon::now('utc')->subMonths(6)->toDateTime();

        $reportWeight = ReportWeight::select('updated_at')->where('user_id', $userId)->orderBy('updated_at', 'desc')->first();
        if ($reportWeight instanceof ReportWeight) {
            $lastAssignedDate = new DateTime($reportWeight->updated_at,'utc');
        }

        $companyEventEntitiesIds = Arr::pluck(
            $this->iplannerService->getEventEntities(
                $lastAssignedDate,
                [EventCodes::CONFERENCE_CODE, EventCodes::MEETING_CODE],
                $client->IPREO_ContactID
            )['DmEventEntity'],
            'company_id'
        );

        $companySubscriptionsIds = Subscription::select('subscribable_id')->where(
            ['subscribable_type' => Subscription::COMPANY_SUBSCRIPTION_TYPE, 'user_id' => $userId]
        )->get()->pluck('subscribable_id')->toArray();

        $this->assignWeights($userId, $companyEventEntitiesIds, 2);
        $this->assignWeights($userId, $companySubscriptionsIds, 1);
    }

    private function assignWeights(int $userId, array $companyIds, int $weight) : void
    {
        $now = Carbon::now('utc')->toDateTimeString();
        $existingCompanyIds = ReportWeight::whereIn('company_id', $companyIds)->where('user_id', $userId)->pluck(
            'company_id'
        )->toArray();

        $newCompanyIds = array_diff($companyIds, $existingCompanyIds);

        $bulkInsertData = [];
        foreach ($newCompanyIds as $newCompanyId) {
            $bulkInsertData[] = [
                'company_id' => $newCompanyId,
                'user_id'    => $userId,
                'weight'     => $weight,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        ReportWeight::insert($bulkInsertData);
        ReportWeight::whereIn('company_id', $existingCompanyIds)->increment('weight', $weight, ['updated_at' => Carbon::now()]);
    }

}
