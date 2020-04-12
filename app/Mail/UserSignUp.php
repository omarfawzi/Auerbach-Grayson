<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\View\View;

class UserSignUp extends Mailable
{
    use Queueable, SerializesModels;

    /** @var User $user */
    protected $user;

    /** @var View $userView */
    protected $userView;

    /**
     * UserSignUp constructor.
     *
     * @param User $user
     * @param View $userView
     */
    public function __construct(User $user, View $userView)
    {
        $this->user     = $user;
        $this->userView = $userView;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view(
            $this->userView->getName(),
            array_merge(
            $this->userView->getData(),
            [
                'user' => $this->user,
            ])
        );
    }

}
