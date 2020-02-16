<?php

namespace App\Repositories;

use App\Models\SQL\Client;

class ClientRepository
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
