<?php

namespace App\Transformers;

use App\Models\Subscription;
use League\Fractal\TransformerAbstract;

class SubscriptionTransformer extends TransformerAbstract
{
    /**
     * @param Subscription $subscription
     * @return array
     */
    public function transform(Subscription $subscription): array
    {
        return $subscription->toArray();
    }
}
