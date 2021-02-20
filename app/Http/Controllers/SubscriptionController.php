<?php

namespace App\Http\Controllers;

use App\Factories\HookFactory;
use App\Factories\TransformerFactory;
use App\Hooks\SubscribeHook;
use App\Hooks\UnsubscribeHook;
use App\Repositories\SubscriptionRepository;
use App\Traits\FractalView;
use App\Transformers\MessageTransformer;
use App\Transformers\SubscriptionTransformer;
use App\Validators\SubscriptionValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class SubscriptionController
{
    use FractalView;

    /** @var SubscriptionRepository $subscriptionRepository */
    protected $subscriptionRepository;

    /** @var TransformerFactory $transformerFactory */
    protected $transformerFactory;

    /** @var SubscriptionValidator $subscriptionValidator */
    protected $subscriptionValidator;

    /** @var HookFactory $hookFactory */
    protected $hookFactory;

    /**
     * SubscriptionController constructor.
     *
     * @param SubscriptionRepository $subscriptionRepository
     * @param TransformerFactory     $transformerFactory
     * @param SubscriptionValidator  $subscriptionValidator
     * @param HookFactory            $hookFactory
     */
    public function __construct(
        SubscriptionRepository $subscriptionRepository,
        TransformerFactory $transformerFactory,
        SubscriptionValidator $subscriptionValidator,
        HookFactory $hookFactory
    ) {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->transformerFactory     = $transformerFactory;
        $this->subscriptionValidator  = $subscriptionValidator;
        $this->hookFactory            = $hookFactory;
    }

    /**
     * @OA\Delete(
     *     path="/subscriptions/{id}",
     *     summary="Remove Subscription",
     *     tags={"Subscriptions"},
     *     @OA\Parameter(in="path",name="id",required=true,@OA\Schema(type="number")),
     *     @OA\Response(
     *        response="200",
     *        description="Remove Subscription",
     *        @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *             @OA\Property(property="data",ref="#/components/schemas/Message")
     *          )
     *       )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Property(ref="#/components/schemas/NotFoundException")
     *        )
     *    )
     * )
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request, int $id)
    {

        if($request->get('userID') != -1 && $request->get('userID') > 0){
            $userID = $request->get('userID');
        }elseif($request->get('userID') == 0){
            $userID = $request->user()->id;
        }else{
            return false;
        }
        $this->hookFactory->make(UnsubscribeHook::class)->hook(
            $this->subscriptionRepository->getSubscription($userID, $id)
        );

        $this->subscriptionRepository->destroy($userID, $id);

        return $this->singleView(
            'Unsubscribed Successfully',
            $this->transformerFactory->make(MessageTransformer::class)
        );
    }

    /**
     * @OA\Get(
     *     path="/subscriptions",
     *     summary="Get Subscriptions",
     *     tags={"Subscriptions"},
     *     @OA\Parameter(in="query",name="pagination",@OA\Schema(ref="#/components/schemas/ListParams")),
     *     @OA\Parameter(in="query",name="type",required=false,@OA\Schema(type="string")),
     *     @OA\Response(
     *        response="200",
     *        description="Get Subscriptions",
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *            @OA\Property(property="data",type="array",@OA\Items(type="object",ref="#/components/schemas/Subscription")),
     *            @OA\Property(property="meta", ref="#/components/schemas/Meta")
     *        )
     *      )
     *    )
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $userID = -1;
        if($request->get('userID') != -1 && $request->get('userID') > 0){
            $userID = $request->get('userID');
        }elseif($request->get('userID') == 0){
            $userID = $request->user()->id;
        }
        $subscriptions = $this->subscriptionRepository->getSubscriptions(
            $userID,
            $request->get('limit', config('api.defaults.limit')),
            $request->all()
        );

        return $this->listView($subscriptions, $this->transformerFactory->make(SubscriptionTransformer::class));
    }

    /**
     * @OA\Post(
     *     path="/subscriptions",
     *     summary="Add Subscription",
     *     tags={"Subscriptions"},
     *     @OA\RequestBody(
     *        @OA\MediaType(mediaType="application/json",@OA\Schema(ref="#/components/schemas/SubscriptionInput"))
     *     ),
     *     @OA\Response(
     *        response="200",
     *        description="Add Subscription",
     *        @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *             @OA\Property(property="data",ref="#/components/schemas/Subscription")
     *          )
     *       )
     *     )
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $userID = -1;
        if($request->get('userID') != -1 && $request->get('userID') > 0){
            $userID = $request->get('userID');
        }elseif($request->get('userID') == 0){
            $userID = $request->user()->id;
        }

        $this->subscriptionValidator->validate($request);

        $subscription = $this->subscriptionRepository->store(
            $request->get('type'),
            $request->get('id'),
            $userID
        );

        $this->hookFactory->make(SubscribeHook::class)->hook($subscription);

        return $this->singleView($subscription, $this->transformerFactory->make(SubscriptionTransformer::class));
    }

}
