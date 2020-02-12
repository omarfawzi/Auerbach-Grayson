<?php

namespace App\Http\Controllers;

use App\Auth;
use App\Events\User\UserSignUp;
use App\Exceptions\UnauthorizedException;
use App\Models\SQL\Client;
use App\Models\User;
use App\Services\ClientService;
use App\Services\UserService;
use App\Transformers\TokenTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /** @var Auth $auth */
    protected $auth;

    /** @var TokenTransformer $tokenTransformer */
    protected $tokenTransformer;

    /** @var UserTransformer $userTransformer */
    protected $userTransformer;

    /** @var ClientService $clientService */
    protected $clientService;

    /** @var UserService $userService */
    protected $userService;

    /**
     * AuthController constructor.
     *
     * @param Auth             $auth
     * @param TokenTransformer $tokenTransformer
     * @param UserTransformer  $userTransformer
     * @param ClientService    $clientService
     * @param UserService      $userService
     */
    public function __construct(
        Auth $auth,
        TokenTransformer $tokenTransformer,
        UserTransformer $userTransformer,
        ClientService $clientService,
        UserService $userService
    ) {
        $this->auth             = $auth;
        $this->tokenTransformer = $tokenTransformer;
        $this->userTransformer  = $userTransformer;
        $this->clientService    = $clientService;
        $this->userService      = $userService;
    }


    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(['email','password']),[
            'email' => 'required',
            'password' => 'required',
        ]);

        $validator->validate();

        $client = $this->clientService->getClientByEmail($request->input('email'));

        if (!$client instanceof Client) {
            throw new UnauthorizedException();
        }

        $user = $this->userService->getUserByEmail($request->input('email'));

        if ($user instanceof User) {
            $token = $this->auth->authenticateByEmailAndPassword(
                $request->input('email'),
                $request->input('password')
            );
            $response = $this->tokenTransformer->transform($token);
        }
        else {
            event(new UserSignUp($user));
            $response = [
                'message' => 'Email Sent to User with new password'
            ];
        }

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Get the authenticated Client.
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        $user = $this->auth->getAuthenticatedUser();

        return response()->json($this->userTransformer->transform($user), Response::HTTP_OK);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function update(): JsonResponse
    {
        $token = $this->auth->refreshAuthenticationToken();

        return response()->json($this->tokenTransformer->transform($token), Response::HTTP_OK);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function destroy(): JsonResponse
    {
        $this->auth->invalidateAuthenticationToken();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
