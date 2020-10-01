<?php

namespace App\Console\Commands;


use App\Repositories\CompanyRepository;
use App\Repositories\ReportRepository;
use App\Repositories\UserRepository;
use App\Jobs\SendReportEmailJob;
use Exception;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendingReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will send the report to the clients based on their behavior';

    /** @var UserRepository $userRepository */
    /** @var ReportRepository $reportRepository */
    private $userRepository;
    private $reportRepository;
    private $companyRepository;

    /**
     * AssigningWeightAlgorithmCommand constructor.
     *
     * @param UserRepository           $userRepository
     * @param ReportRepository         $reportRepository
     * @param CompanyRepository         $companyRepository
     */
    public function __construct(
        UserRepository $userRepository,
        ReportRepository $reportRepository,
        CompanyRepository $companyRepository
    ) {
        $this->userRepository           = $userRepository;
        $this->reportRepository           = $reportRepository;
        $this->companyRepository           = $companyRepository;
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Starting the sending report command ...');

        $dtCurrentDate = Carbon::now('utc')->toDate()."00:00:00";

        $reports = $this->reportRepository->getReportsByDate($dtCurrentDate);

        if(empty($reports)){
            $this->warn('No Reports found');
            return true;
        }

        foreach($reports as $report){
            $companiesID = $this->CompanyRepoitory->getReportCompanies($report->id);
            if(empty($companiesID)){
                continue;
            }

            $users = $this->userRepository->getUsersSubscripedToCompany($companiesID);
            if(empty($users)){
                continue;
            }

            foreach ($users as $user){
                try {
                    // Add Queue Job
                    SendReportEmailJob::dispatch($report, $user);
                } catch (Exception $exception) {
                    $this->error("Exception happened while sending report : {$exception->getMessage()}");
                }
            }
        }
        return true;
    }
}
