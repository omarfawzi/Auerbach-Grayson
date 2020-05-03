<?php

namespace App\Console\Commands;

use App\Constants\EventCodes;
use App\Models\User;
use App\Services\IPlannerService;
use App\Services\WeightAssignationService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class AssigningWeightAlgorithm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weight:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will update the recommendation weight for the clients';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private $iplannerService;
    private $weightAssignationService;
    private $user;

    public function __construct(IPlannerService $iplannerService, WeightAssignationService $weightAssignationService, User $user)
    {
        $this->iplannerService = $iplannerService;
        $this->weightAssignationService = $weightAssignationService;
        $this->user = $user;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Here we will create a log ... starting the cron job

        $lastAssignedDate = Carbon::now('utc')->subMonths(6)->toDateTime();
        $contactEvents = $this->iplannerService->getEventEntities($lastAssignedDate, [EventCodes::CONFERENCE_CODE, EventCodes::MEETING_CODE]);
        if(empty($contactEvents)){
            // Create a log ... success end with empty contacts
            return true;
        }

        $clientWeights = array();

        foreach($contactEvents as $clientID => $companiesID){

            $user = $this->user->getUserByClientID($clientID);
            $rslt = $this->weightAssignationService->assign(1, $companiesID);
            //$rslt = $this->weightAssignationService->assign($user->id, $companiesID);
            if(!$rslt){
                // Create failed log with the client ID
            }
        }
        // Create sucess end log
        return true;
    }

}
