<?php

namespace App\Http\Controllers;

use App\Auth;
use App\Transformers\TokenTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /** @var Auth $auth */
    protected $auth;

    /**
     * Controller constructor.
     *
     * @param Auth $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $token = $this->auth->authenticateByEmailAndPassword(
            $request->input('email'),
            $request->input('password')
        );

        return response()->json(fractal($token, new TokenTransformer())->toArray(), Response::HTTP_OK);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        $user = $this->auth->getAuthenticatedUser();

        return response()->json(fractal($user, new UserTransformer())->toArray(), Response::HTTP_OK);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function update(): JsonResponse
    {
        $token = $this->auth->refreshAuthenticationToken();

        return response()->json(fractal($token, new TokenTransformer())->toArray(), Response::HTTP_OK);
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
