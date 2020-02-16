<?php

namespace App\Events\User;

use App\Events\Event;
use App\Models\SQL\Client;

class ClientSignUp extends Event
{
    /** @var Client $client */
    public $client;

    /**
     * Create a new event instance.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
