<?php


namespace App\Jobs;

use App\Models\SQL\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Services\MailService;


class SendReportEmailJob
{
    protected $report;
    protected $user;
    protected $mailService;
    /**
     * Create a new job instance.
     *
     * @param Carbon $currentDate
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
        $this->mailService->email([$this->user->getEmail()],'',[$this->report],view('email.report'));
    }


}
