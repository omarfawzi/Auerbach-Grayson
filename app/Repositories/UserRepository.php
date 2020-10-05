<?php

namespace App\Repositories;

use App\Models\ReportWeight;
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
        if(!empty($client)){
            return User::query()->where('email', $client->Email)->first();
        }
        return null;
    }

    public function getUsersSubscripedToCompany($companiesID)
    {
        if(empty($companiesID)){
            return array();
        }

        $userIDs =  ReportWeight::query()
                        ->select('user_id')
                        ->whereIn('company_id', $companiesID)->pluck('user_id')->toArray();
        if(empty($userIDs)){
            return array();
        }

        return User::query()->whereIn('id', $userIDs)->get();
    }
}
