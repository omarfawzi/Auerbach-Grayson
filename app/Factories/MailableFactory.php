<?php

namespace App\Factories;

use App\Mail\ContactAnalyst;
use App\Mail\SendReport;
use App\Mail\UserSignUp;
use App\Models\SQL\Analyst;
use App\Models\SQL\Report;
use App\Models\User;
use Illuminate\Mail\Mailable;
use App\Contracts\Mailable as MailableContract;
use Illuminate\View\View;
use InvalidArgumentException;

class MailableFactory
{
    /**
     * @param MailableContract $mailable
     * @param View     $view
     * @return Mailable
     */
    public function make(MailableContract $mailable, View $view): Mailable
    {
        switch (true) {
            case $mailable instanceof Analyst:
                return new ContactAnalyst($mailable, $view);
            case $mailable instanceof User:
                return new UserSignUp($mailable, $view);
            case $mailable instanceof Report:
                return new SendReport($mailable, $view);

            default:
                throw new InvalidArgumentException('Mailable not found');
        }
    }
}
