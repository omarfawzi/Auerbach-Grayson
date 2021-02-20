<?php

namespace App\Repositories;

use App\Models\ReportView;
use App\Models\ReportWeight;
use App\Models\SQL\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    /**
     * Get a user by ID.
     *
     * @param  string  $email
     **
     * @return User
     */

    public function getUsers(int $limit , array $filters = []) : LengthAwarePaginator
    {
        return User::filter($filters)->paginate($limit);
    }


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

    public function makeAsAdmin(int $userId)
    {
        $user = User::findOrFail($userId);
        if($user) {
            $user->is_admin = 1;
            $user->save();
            return true;
        }
        return false;
    }

    public function deactivate(int $userId)
    {
        $user = User::findOrFail($userId);
        if($user) {
            $user->is_available = 0;
            $user->save();
            return true;
        }
        return false;
    }

}
