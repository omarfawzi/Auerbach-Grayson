<?php

namespace App\Mail;

use App\Models\SQL\Analyst;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactAnalyst extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Analyst $analyst */
    protected $analyst;

    /**
     * Create a new message instance.
     *
     * @param Analyst $analyst
     */
    public function __construct(Analyst $analyst)
    {
        $this->analyst = $analyst;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('')->with(['analyst' => $this->analyst]);
    }
}
