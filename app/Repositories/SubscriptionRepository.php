<?php

namespace App\Repositories;

use App\Models\Subscription;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SubscriptionRepository
{
    /**
     * @param int $userId
     * @param int $limit
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getSubscriptions(int $userId , int $limit , array $filters = []) : LengthAwarePaginator
    {
        return Subscription::filter($filters)->where('user_id',$userId)->paginate($limit);
    }

    /**
     * @param string $subscribableType
     * @param string $subscribableId
     * @param string $userId
     * @return Subscription
     */
    public function store(string $subscribableType, string $subscribableId, string $userId): Subscription
    {
        $subscription = new Subscription();
        $subscription->subscribable_id = $subscribableId;
        $subscription->subscribable_type = $subscribableType;
        $subscription->user_id = $userId;
        $subscription->save();
        return $subscription;
    }
}
