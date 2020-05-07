<?php

namespace App\Providers;

use App\Events\User\ClientSignUp;
use App\Events\User\UserForgetPassword;
use App\Listeners\SendForgetPasswordEmail;
use App\Listeners\SendSignUpEmail;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ClientSignUp::class => [
            SendSignUpEmail::class,
        ],
        UserForgetPassword::class => [
            SendForgetPasswordEmail::class
        ]
    ];
}
