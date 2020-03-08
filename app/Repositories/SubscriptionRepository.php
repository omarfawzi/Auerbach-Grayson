<?php

namespace App\Repositories;

use App\Models\Subscription;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SubscriptionRepository
{
    /**
     * @param int $userId
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getSubscriptions(int $userId , int $limit) : LengthAwarePaginator
    {
        return Subscription::where('user_id',$userId)->paginate($limit);
    }
}
