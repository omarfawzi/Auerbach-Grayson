<?php

namespace App;

use App\Exceptions\UnauthorizedException;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class Auth
{
    /**
     * Authenticate a user by email and password
     *
     * @param string $email
     * @param string $password
     *
     * @return string
     */
    public function authenticateByEmailAndPassword(string $email, string $password): string
    {
        if (!$token = app('auth')->attempt(compact('email', 'password'))) {
            throw new UnauthorizedException();
        }

        return $token;
    }

    /**
     * Get the current authenticated user.
     *
     * @return User
     */
    public static function getAuthenticatedUser(): User
    {
        return app('auth')->user();
    }

    /**
     * Refresh current authentication token.
     *
     * @return string
     */
    public function refreshAuthenticationToken(): string
    {
        return app('auth')->refresh();
    }

    /**
     * Invalidate current authentication token.
     *
     * @return void
     */
    public function invalidateAuthenticationToken(): void
    {
       app('auth')->logout();
    }
}
