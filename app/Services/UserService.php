<?php

namespace App\Services;

use App\Events\UserCreated;
use App\Events\UserUpdated;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserService
{
    /**
     * Get list of paginated users.
     *
     * @param Request $request
     *
     * @return array
     */
    public function getUsersWithPagination(Request $request): array
    {
        $users = User::filter($request)->paginate();


        return fractal($users, new UserTransformer())->toArray();
    }

    /**
     * Get a user by ID.
     *
     * @param  int  $id
     *
     * @throws ModelNotFoundException
     *
     * @return array
     */
    public function getUserById(int $id): array
    {
        $user = User::findOrFail($id);

        return fractal($user, new UserTransformer())->toArray();
    }

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

    /**
     * Store a new user.
     *
     * @param  array  $attrs
     *
     * @return array
     * @throws ValidationException
     *
     */
    public function storeUser(array $attrs): array
    {
        $user = new User($attrs);

        if (!$user->isValid()) {
            throw new ValidationException($user->validator());
        }

        $user->save();

        event(new UserCreated($user));

        return fractal($user, new UserTransformer())->toArray();
    }

    /**
     * Update a user by ID.
     *
     * @param  int  $id
     * @param  array  $attrs
     *
     * @return array
     *@throws ValidationException
     *
     * @throws ModelNotFoundException
     */
    public function updateUserById(int $id, array $attrs): array
    {
        $user = User::findOrFail($id);
        $user->fill($attrs);
        $changes = $user->getDirty();

        if (!$user->isValid()) {
            throw new ValidationException($user->validator());
        }

        $user->save();

        event(new UserUpdated($user, $changes));

        return fractal($user, new UserTransformer())->toArray();
    }

    /**
     * Delete a user by ID.
     *
     * @param  int  $id
     *
     * @throws ModelNotFoundException
     *
     * @return bool
     */
    public function deleteUserById(int $id): bool
    {
        $user = User::findOrFail($id);

        if (!$user->delete()) {
            return false;
        }

        return true;
    }
}
