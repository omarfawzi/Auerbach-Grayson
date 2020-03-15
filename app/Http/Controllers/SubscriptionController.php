<?php

namespace App\Http\Controllers;

use App\Factories\TransformerFactory;
use App\Models\Subscription;
use App\Repositories\SubscriptionRepository;
use App\Traits\FractalView;
use App\Transformers\SubscriptionTransformer;
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

    /**
     * SubscriptionController constructor.
     *
     * @param SubscriptionRepository $subscriptionRepository
     * @param TransformerFactory $transformerFactory
     */
    public function __construct(SubscriptionRepository $subscriptionRepository, TransformerFactory $transformerFactory)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->transformerFactory = $transformerFactory;
    }


    /**
     * @OA\Get(
     *     path="/subscriptions",
     *     summary="Get Subscriptions",
     *     tags={"Subscriptions"},
     *     @OA\Parameter(in="query",name="pagination",@OA\Schema(ref="#/components/schemas/ListParams")),
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
        $subscriptions = $this->subscriptionRepository->getSubscriptions($request->user()->id, $request->get('limit', config('api.defaults.limit')));
        return $this->listView($subscriptions, $this->transformerFactory->make(SubscriptionTransformer::class));
    }

    /**
     * @OA\Post(
     *     path="/subscriptions",
     *     summary="Add Subscription",
     *     tags={"Subscriptions"},
     *     @OA\RequestBody(
     *        request="Subscription",
     *        @OA\MediaType(mediaType="application/json",@OA\Schema(ref="#/components/schemas/SubscriptionInput"))
     *     ),
     *     @OA\Response(
     *        response="200",
     *        description="Get Subscription",
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
        Subscription::validate($request);
        $subscription = Subscription::store($request->get('type'), $request->get('id'), $request->user()->id);
        return $this->singleView($subscription, $this->transformerFactory->make(SubscriptionTransformer::class));
    }

}
