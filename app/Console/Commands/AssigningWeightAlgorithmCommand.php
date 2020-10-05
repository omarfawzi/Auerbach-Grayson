<?php

namespace App\Console\Commands;

use App\Constants\EventCodes;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\IPlannerService;
use App\Services\WeightAssignationService;
use Exception;
use Illuminate\Console\Command;
use Carbon\Carbon;

class AssigningWeightAlgorithmCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign:weight';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will update the recommendation weight for the clients';

    /** @var IPlannerService $iplannerService */
    private $iplannerService;

    /** @var WeightAssignationService $weightAssignationService */
    private $weightAssignationService;

    /** @var UserRepository $userRepository */
    private $userRepository;

    /**
     * AssigningWeightAlgorithmCommand constructor.
     *
     * @param IPlannerService          $iplannerService
     * @param WeightAssignationService $weightAssignationService
     * @param UserRepository           $userRepository
     */
    public function __construct(
        IPlannerService $iplannerService,
        WeightAssignationService $weightAssignationService,
        UserRepository $userRepository
    ) {
        $this->iplannerService          = $iplannerService;
        $this->weightAssignationService = $weightAssignationService;
        $this->userRepository           = $userRepository;
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Starting the assigning weight algorithm ...');

        $lastAssignedDate = Carbon::now('utc')->subMonths(6)->toDateTime();

        $contactEvents = $this->iplannerService->getEventEntities($lastAssignedDate, [EventCodes::CONFERENCE_CODE, EventCodes::MEETING_CODE, EventCodes::CONFERENCE_CALL_CODE, EventCodes::DEAL_RELATED_CODE, EventCodes::STANDARD_EVENT_CODE]);

        if(empty($contactEvents)){
            $this->warn('No contact events found');
            return true;
        }

        foreach($contactEvents as $clientID => $companiesID){

            $user = $this->userRepository->getUserByClientID($clientID);

            if ($user instanceof User) {
                try {
                    $this->weightAssignationService->assign($user->id, $lastAssignedDate, $companiesID);
                } catch (Exception $exception) {
                    $this->error("Exception happened while assigning weights : {$exception->getMessage()}");
                }
            }
        }
        return true;
    }

}
