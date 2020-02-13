<?php

namespace App\Http\Controllers;

use App\Auth;
use App\Events\User\ClientSignUp;
use App\Exceptions\UnauthorizedException;
use App\Factories\TransformerFactory;
use App\Models\SQL\Client;
use App\Models\User;
use App\Repositories\ClientRepository;
use App\Repositories\UserRepository;
use App\Transformers\MessageTransformer;
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

    /** @var ClientRepository $clientRepository */
    protected $clientRepository;

    /** @var UserRepository $userRepository */
    protected $userRepository;

    /** @var TransformerFactory $transformerFactory */
    protected $transformerFactory;

    /**
     * AuthController constructor.
     *
     * @param Auth               $auth
     * @param TransformerFactory $transformerFactory
     * @param ClientRepository   $clientRepository
     * @param UserRepository     $userRepository
     */
    public function __construct(
        Auth $auth,
        TransformerFactory $transformerFactory,
        ClientRepository $clientRepository,
        UserRepository $userRepository
    ) {
        $this->transformerFactory = $transformerFactory;
        $this->auth               = $auth;
        $this->clientRepository   = $clientRepository;
        $this->userRepository     = $userRepository;
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

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(['email', 'password']),
            [
                'email'    => 'required',
                'password' => 'required',
            ]
        );
        $validator->validate();

        $client = $this->clientRepository->getClientByEmail($request->input('email'));

        if (!$client instanceof Client) {
            throw new UnauthorizedException();
        }

        $user = $this->userRepository->getUserByEmail($request->input('email'));

        if ($user instanceof User) {
            $token    = $this->auth->authenticateByEmailAndPassword(
                $request->input('email'),
                $request->input('password')
            );
            $response = $this->transformerFactory->make(TokenTransformer::class)->transform($token);
        } else {
            event(new ClientSignUp($client));
            $response = $this->transformerFactory->make(MessageTransformer::class)->transform(
                'Email Sent Successfully'
            );
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

        return response()->json(
            $this->transformerFactory->make(UserTransformer::class)->transform($user),
            Response::HTTP_OK
        );
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function update(): JsonResponse
    {
        $token = $this->auth->refreshAuthenticationToken();

        return response()->json(
            $this->transformerFactory->make(TokenTransformer::class)->transform($token),
            Response::HTTP_OK
        );
    }
}
