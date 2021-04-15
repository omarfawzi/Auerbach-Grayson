<?php

namespace App\Mail;

use App\Models\SQL\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\View\View;

class SendReport extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Report $report */
    protected $report;

    /** @var View $reportView */
    protected $reportView;

    /**
     * UserSignUp constructor.
     *
     * @param Report $report
     * @param View $reportView
     */
    public function __construct(Report $report, View $reportView)
    {
        $this->report     = $report;
        $this->reportView = $reportView;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "";

        $subject.= $this->report->report_title;
        $subject.= " (".$this->report->Pages . "pgs)";

        return $this->subject($subject)->view(
            $this->reportView->getName(),
            array_merge(
                $this->reportView->getData(),
                [
                    'report' => $this->report,
                ])
        );
    }

}
