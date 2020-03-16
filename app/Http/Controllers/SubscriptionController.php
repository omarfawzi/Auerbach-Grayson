<?php

namespace App\Http\Controllers;

use App\Factories\TransformerFactory;
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

    /**
     * SubscriptionController constructor.
     * @param SubscriptionRepository $subscriptionRepository
     * @param TransformerFactory $transformerFactory
     * @param SubscriptionValidator $subscriptionValidator
     */
    public function __construct(SubscriptionRepository $subscriptionRepository, TransformerFactory $transformerFactory, SubscriptionValidator $subscriptionValidator)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->transformerFactory = $transformerFactory;
        $this->subscriptionValidator = $subscriptionValidator;
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
        $subscriptions = $this->subscriptionRepository->getSubscriptions($request->user()->id, $request->get('limit', config('api.defaults.limit')), $request->all());
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
        $this->subscriptionValidator->validate($request);
        $subscription = $this->subscriptionRepository->store($request->get('type'), $request->get('id'), $request->user()->id);
        return $this->singleView($subscription, $this->transformerFactory->make(SubscriptionTransformer::class));
    }

    /**
     * @OA\Delete(
     *     path="/subscriptions",
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
     *     )
     * )
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $this->subscriptionRepository->destroy($id);
        return $this->singleView('Unsubscribed Succesfully',$this->transformerFactory->make(MessageTransformer::class));
    }

}
