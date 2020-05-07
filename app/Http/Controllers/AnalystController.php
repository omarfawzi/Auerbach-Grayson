<?php


namespace App\Http\Controllers;


use App\Models\SQL\Report;
use App\Repositories\ReportRepository;
use App\Services\MailService;
use Illuminate\Http\Request;

class AnalystController
{
    /** @var ReportRepository $reportRepository */
    protected $reportRepository;

    /** @var MailService $mailService */
    protected $mailService;

    /**
     * AnalystController constructor.
     * @param ReportRepository $reportRepository
     * @param MailService $mailService
     */
    public function __construct(ReportRepository $reportRepository, MailService $mailService)
    {
        $this->reportRepository = $reportRepository;
        $this->mailService = $mailService;
    }


    /**
     * @param int $id
     */
    public function contact(int $id)
    {
        $report = $this->reportRepository->getReport($id);
        if ($report instanceof Report) {
            $this->mailService->email([], env('ANALYST_MAIL_CC'), $report->analysts, view('email.contact_analyst'));
        }
    }

    /**
     * @param Request $request
     * @param int $id
     */
    public function email(Request $request, int $id)
    {
        $report = $this->reportRepository->getReport($id);
        if ($report instanceof Report) {
            $this->mailService->email([], env('ANALYST_MAIL_CC'), $report->analysts, view('email.email_analyst'));
        }
    }

}
