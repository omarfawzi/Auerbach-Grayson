<?php

namespace App\Repositories;

use App\Models\SQL\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * @param int $clientID
     * @return User|null
     */
    public function getUserByClientID(int $clientID) :?Model
    {
        $client = Client::query()->where('IPREO_ContactID', $clientID)->first();

        return User::query()->where('email', $client->Email)->first();
    }
}
