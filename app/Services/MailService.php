<?php

namespace App\Services;

use App\Contracts\Mailable;
use App\Factories\MailableFactory;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class MailService
{
    /** @var MailableFactory $mailableFactory */
    protected $mailableFactory;

    /**
     * MailService constructor.
     *
     * @param MailableFactory $mailableFactory
     */
    public function __construct(MailableFactory $mailableFactory) { $this->mailableFactory = $mailableFactory; }


    /**
     * @param array $to
     * @param string $cc
     * @param Mailable[] $mailables
     * @param View $view
     */
    public function email(array $to, string $cc, array $mailables , View $view)
    {
        foreach ($mailables as $mailable) {
            Mail::to($to)->cc($cc)->send($this->mailableFactory->make($mailable,$view));
        }
    }
}
