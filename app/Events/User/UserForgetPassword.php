<?php

namespace App\Events\User;

use App\Events\Event;
use App\Models\User;

class UserForgetPassword extends Event
{
    /** @var User $user */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
