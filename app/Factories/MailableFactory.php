<?php

namespace App\Factories;

use App\Mail\ContactAnalyst;
use App\Models\SQL\Analyst;
use Illuminate\Mail\Mailable;
use InvalidArgumentException;

class MailableFactory
{
    /**
     * @param object $mailable
     * @return Mailable
     */
    public function make(object $mailable) : Mailable
    {
        switch (true)
        {
            case $mailable instanceof Analyst:
                return new ContactAnalyst($mailable);
            default:
                throw new InvalidArgumentException("Mailable not found");
        }
    }
}
