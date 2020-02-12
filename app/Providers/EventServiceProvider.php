<?php

namespace App\Providers;

use App\Events\User\UserSignUp;
use App\Listeners\SendWelcomeEmail;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserSignUp::class => [
            SendWelcomeEmail::class,
        ]
    ];
}
