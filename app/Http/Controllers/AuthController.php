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
use App\Traits\FractalView;
use App\Transformers\MessageTransformer;
use App\Transformers\TokenTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use FractalView;

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
            $token = $this->auth->authenticateByEmailAndPassword(
                $request->input('email'),
                $request->input('password')
            );

            return $this->singleView($token, $this->transformerFactory->make(TokenTransformer::class));
        } else {

            event(new ClientSignUp($client));

            return $this->singleView(
                config('api.messages.reset_password_email'),
                $this->transformerFactory->make(MessageTransformer::class)
            );
        }
    }
}
