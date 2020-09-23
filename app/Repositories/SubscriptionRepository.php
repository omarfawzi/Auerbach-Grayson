<?php

namespace App\Repositories;

use App\Models\ReportWeight;
use App\Models\Subscription;
use DateTime;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SubscriptionRepository
{
    /**
     * @param int $userId
     * @param int $id
     * @return Subscription
     */
    public function getSubscription(int $userId, int $id): Subscription
    {
        return Subscription::query()->where(['user_id'=>$userId,'id'=>$id])->first();
    }

    /**
     * @param int   $userId
     * @param int   $limit
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getSubscriptions(int $userId, int $limit, array $filters = []): LengthAwarePaginator
    {
        return Subscription::filter($filters)->where('user_id', $userId)->paginate($limit);
    }

    /**
     * @param string $subscribableType
     * @param int    $subscribableId
     * @param string $userId
     * @return Subscription
     */
    public function store(string $subscribableType, int $subscribableId, string $userId): Subscription
    {
        $subscription                    = new Subscription();
        $subscription->subscribable_id   = $subscribableId;
        $subscription->subscribable_type = $subscribableType;
        $subscription->user_id           = $userId;
        $subscription->save();

        return $subscription;
    }

    /**
     * @param int $userId
     * @param int $id
     */
    public function destroy(int $userId, int $id): void
    {
        Subscription::query()->where(['user_id' => $userId, 'id' => $id])->decrement('weight', 1);
        Subscription::query()->where(['user_id' => $userId, 'id' => $id, 'weight'=> 0])->delete();

    }

    /**
     * @param int      $userId
     * @param string   $type
     * @param DateTime $dateTime
     * @return array
     */
    public function getUserSubscribableIdsAfter(int $userId, string $type, DateTime $dateTime): array
    {
        return Subscription::query()->select('subscribable_id')
            ->where(['subscribable_type' => $type, 'user_id' => $userId])
            ->whereDate('created_at', '>', $dateTime)
            ->get()->pluck('subscribable_id')->toArray();
    }
}
