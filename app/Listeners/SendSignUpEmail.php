<?php

namespace App\Listeners;

use App\Events\User\ClientSignUp;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Support\Str;

class SendSignUpEmail
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
     * @param  ClientSignUp  $event
     * @return void
     */
    public function handle(ClientSignUp $event)
    {
        $plainPassword = Str::random(16);

        $user = new User();

        $user->setEmail($event->client->getEmail());

        $user->setName($event->client->getName());

        $user->setPassword(app('hash')->make($plainPassword));

        $user->setPlainPassword($plainPassword);

        $user->save();

        $this->mailService->email([$user->getEmail()],'',[$user], view('email.user_credentials'));
    }
}
