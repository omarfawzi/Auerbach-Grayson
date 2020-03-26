<?php

namespace App\Transformers;

use App\Models\Subscription;
use League\Fractal\TransformerAbstract;

class SubscriptionTransformer extends TransformerAbstract
{
    /** @var SubscribableTransformer $subscribableTransformer */
    protected $subscribableTransformer;

    /**
     * SubscriptionTransformer constructor.
     *
     * @param SubscribableTransformer $subscribableTransformer
     */
    public function __construct(SubscribableTransformer $subscribableTransformer)
    {
        $this->subscribableTransformer = $subscribableTransformer;
    }


    /**
     * @param Subscription $subscription
     * @return array
     */
    public function transform(Subscription $subscription): array
    {
        return [
            'id'           => $subscription->id,
            'type'         => $subscription->subscribable_type,
            'subscribable' => $this->subscribableTransformer->transform($subscription->subscribable),
        ];
    }
}
