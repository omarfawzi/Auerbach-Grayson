<?php

namespace App\Http\Controllers;

use App\Accounts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param Accounts $accounts
     */
    public function __construct(Accounts $accounts)
    {
        $this->accounts = $accounts;
    }

    /**
     * Get all the users.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $users = $this->accounts->getUsersWithPagination($request);

        return response()->json($users, Response::HTTP_OK);
    }

    /**
     * Store a user.
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $user = $this->accounts->storeUser($request->all());

        return response()->json($user, Response::HTTP_CREATED);
    }

    /**
     * Get a user.
     *
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->accounts->getUserById($id);

        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Update a user.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $user = $this->accounts->updateUserById($id, $request->all());

        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Delete a user.
     *
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->accounts->deleteUserById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
