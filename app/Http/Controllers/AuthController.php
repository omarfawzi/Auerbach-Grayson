<?php

namespace App\Http\Controllers;

use App\Auth;
use App\Events\User\ClientSignUp;
use App\Events\User\UserForgetPassword;
use App\Factories\TransformerFactory;
use App\Models\User;
use App\Repositories\ClientRepository;
use App\Repositories\UserRepository;
use App\Traits\FractalView;
use App\Transformers\MessageTransformer;
use App\Transformers\TokenTransformer;
use App\Transformers\UserTransformer;
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
            $request->all(['email']),
            [
                'email'    => 'required|exists:sqlsrv.Client'
            ],
            [
                'email.exists' => 'The provided :attribute is invalid'
            ]
        );
        $validator->validate();
        $client = $this->clientRepository->getClientByEmail($request->input('email'));

        $user = $this->userRepository->getUserByEmail($request->input('email'));
        if ($user instanceof User) {
            if(!$user->is_available){
                return false;
            }
            $validator = Validator::make(
                $request->all(['password']),
                [
                    'password' => "required|check_hashed_pass:{$user->getPassword()}",
                ],
                [
                    'check_hashed_pass' => 'The provided :attribute is invalid'
                ]
            );
            $validator->validate();
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function forgetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(['email']),
            [
                'email'    => 'required|exists:users'
            ],
            [
                'email.exists' => 'The provided :attribute is invalid'
            ]
        );

        $data = $request->all(['email']);
        $user = $this->userRepository->getUserByEmail($data['email']);
        if ($user instanceof User && !$user->is_available) {
            return false;
        }

        $validator->validate();

        event(new UserForgetPassword($this->userRepository->getUserByEmail($request->get('email'))));

        return $this->singleView(
            config('api.messages.reset_password_email'),
            $this->transformerFactory->make(MessageTransformer::class)
        );
    }

    public function refreshToken(): string
    {
        return $this->singleView(
            Auth::refreshAuthenticationToken(),
            $this->transformerFactory->make(MessageTransformer::class)
        );
    }

    public function getLoggedUser(){
        return $this->singleView(Auth::getAuthenticatedUser(), $this->transformerFactory->make(UserTransformer::class));
    }
}
