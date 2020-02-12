<?php

namespace App\Services;

use App\Models\SQL\Client;

class ClientService
{
    /**
     * @param string $email
     * @return Client
     */
    public function getClientByEmail(string $email) : ?Client
    {
        return Client::where('Email',$email)->first();
    }
}
