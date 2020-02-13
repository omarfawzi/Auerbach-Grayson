<?php

namespace App\Repositories;

use App\Events\UserCreated;
use App\Events\UserUpdated;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserRepository
{
    /**
     * Get a user by ID.
     *
     * @param  string  $email
     **
     * @return User
     */
    public function getUserByEmail(string $email): ?User
    {
        return User::where('email',$email)->first();
    }
}
