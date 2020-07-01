<?php

namespace App\Contracts;

use App\Models\Subscription;

interface SubscriptionHook
{
    public function hook(Subscription $subscription): void;
}
