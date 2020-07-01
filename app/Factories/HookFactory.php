<?php

namespace App\Factories;

use App\Contracts\SubscriptionHook;
use App\Hooks\SubscribeHook;
use App\Hooks\UnsubscribeHook;
use InvalidArgumentException;

class HookFactory
{
    /** @var SubscribeHook $subscribeHook */
    protected $subscribeHook;

    /** @var UnsubscribeHook $unsubcribeHook */
    protected $unsubcribeHook;

    /**
     * HookFactory constructor.
     *
     * @param SubscribeHook   $subscribeHook
     * @param UnsubscribeHook $unsubcribeHook
     */
    public function __construct(SubscribeHook $subscribeHook, UnsubscribeHook $unsubcribeHook)
    {
        $this->subscribeHook  = $subscribeHook;
        $this->unsubcribeHook = $unsubcribeHook;
    }


    /**
     * @param string $hook
     * @return SubscriptionHook
     */
    public function make(string $hook): SubscriptionHook
    {
        switch ($hook) {
            case SubscribeHook::class:
                return $this->subscribeHook;
            case UnsubscribeHook::class:
                return $this->unsubcribeHook;
            default:
                throw new InvalidArgumentException("Invalid {$hook} class provided");
        }
    }
}
