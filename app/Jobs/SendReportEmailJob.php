<?php


namespace App\Jobs;

use App\Models\SQL\Report;
use App\Models\User;
use Carbon\Carbon;
use App\Services\MailService;


class SendReportEmailJob extends Job
{
    protected $report;
    protected $user;
    protected $mailService;

    /**
     * AssigningWeightAlgorithmCommand constructor.
     *
     * @param Report $report
     * @param User $user
     * @param MailService $mailService
     */
     public function __construct(Report $report, User $user, MailService $mailService)
     {
         $this->report = $report;
         $this->user = $user;
         $this->mailService = $mailService;
     }

     /**
      * Execute the job.
      *
      * @return void
      */
     public function handle()
    {
        $this->mailService->email(
                        [$this->user->getEmail()],
                        '',
                        [$this->report],
                        view('email.report')->with(
                            [
                                'user_name' => $this->user->email
                            ]
                        )
        );
    }


}
