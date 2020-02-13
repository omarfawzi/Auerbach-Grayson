<?php

namespace App\Listeners;

use App\Events\User\ClientSignUp;
use App\Models\User;
use Carbon\Carbon;

class SendSignUpEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ClientSignUp  $event
     * @return void
     */
    public function handle(ClientSignUp $event)
    {
        $password = str_random(8);

        $user = new User();

        $user->setEmail($event->client->getEmail());
        $user->setName($event->client->getName());

        $user->setPassword(app('hash')->make($password));

        $user->save();

        //@Todo Send signup email
    }
}
