<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * Get a user by ID.
     *
     * @param  string  $email
     **
     * @return User
     */
    public function getUserByEmail(string $email): ?User
    {
        return User::where('email',$email)->first();
    }
}
