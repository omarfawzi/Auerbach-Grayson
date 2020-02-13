<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /** @var UserRepository $userRepository */
    protected $userRepository;

    /**
     * Controller constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get all the users.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $users = $this->userRepository->getUsersWithPagination($request);

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
        $user = $this->userRepository->storeUser($request->all());

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
        $user = $this->userRepository->getUserById($id);

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
        $user = $this->userRepository->updateUserById($id, $request->all());

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
        $this->userRepository->deleteUserById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
