<?php

namespace App\Factories;

use App\Mail\ContactAnalyst;
use App\Models\SQL\Analyst;
use Illuminate\Mail\Mailable;
use Illuminate\View\View;
use InvalidArgumentException;

class MailableFactory
{
    /**
     * @param object $mailable
     * @param View   $view
     * @return Mailable
     */
    public function make(object $mailable , View $view) : Mailable
    {
        switch (true)
        {
            case $mailable instanceof Analyst:
                return new ContactAnalyst($mailable , $view);
            default:
                throw new InvalidArgumentException("Mailable not found");
        }
    }
}
