<?php

namespace App\Listeners;

use App\Events\User\UserForgetPassword;
use App\Services\MailService;
use Illuminate\Support\Str;

class SendForgetPasswordEmail
{
    /** @var MailService $mailService */
    protected $mailService;

    /**
     * SendSignUpEmail constructor.
     *
     * @param MailService $mailService
     */
    public function __construct(MailService $mailService) { $this->mailService = $mailService; }

    /**
     * Handle the event.
     *
     * @param UserForgetPassword $event
     * @return void
     */
    public function handle(UserForgetPassword $event)
    {
        $plainPassword = Str::random(8);

        $event->user->setPassword(app('hash')->make($plainPassword));

        $event->user->setPlainPassword($plainPassword);

        $event->user->save();

        $this->mailService->email([$event->user->getEmail()],'',[$event->user],view('email.user_credentials'));
    }
}
