<?php


namespace App\Http\Controllers;

use App\Factories\TransformerFactory;
use App\Repositories\UserRepository;
use App\Traits\FractalView;
use App\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Transformers\MessageTransformer;


class UserController extends Controller
{
    use FractalView;

    /** @var UserRepository $userRepository */
    protected $userRepository;

    /** @var TransformerFactory $transformerFactory */
    protected $transformerFactory;

    /**
     * SectorController constructor.
     *
     * @param UserRepository   $userRepository
     * @param TransformerFactory $transformerFactory
     */
    public function __construct(UserRepository $userRepository, TransformerFactory $transformerFactory)
    {
        $this->userRepository   = $userRepository;
        $this->transformerFactory = $transformerFactory;
    }

    public function index(Request $request): JsonResponse
    {
        $users = $this->userRepository->getUsers(
            $request->get('limit', config('api.defaults.limit')),
            $request->all()
        );
        return $this->listView($users, $this->transformerFactory->make(UserTransformer::class));
    }

    public function deactivate(Request $request, $id): JsonResponse
    {
        $this->userRepository->deactivate($id);
        return $this->singleView(
            'Deactivated Successfully',
            $this->transformerFactory->make(MessageTransformer::class)
        );
    }

    public function addAdmin(Request $request, $id): JsonResponse
    {
        $this->userRepository->makeAsAdmin($id);
        return $this->singleView(
            'Added as admin Successfully',
            $this->transformerFactory->make(MessageTransformer::class)
        );
    }



}
