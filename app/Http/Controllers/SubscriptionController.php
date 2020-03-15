<?php

namespace App\Http\Controllers;

use App\Factories\TransformerFactory;
use App\Models\SQL\Company;
use App\Models\SQL\Sector;
use App\Models\Subscription;
use App\Repositories\SubscriptionRepository;
use App\Traits\FractalView;
use App\Transformers\SubscriptionTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $userId = $request->user()->id;
        $subscribableId = $request->get('id');
        $subscribableType = $request->get('type');
        $query = null;
        if ($subscribableType == Subscription::COMPANY_SUBSCRIPTION_TYPE) {
            $query = Company::getTableName() . ',' . Company::getPrimaryKey();
        }
        if ($subscribableType == Subscription::SECTOR_SUBSCRIPTION_TYPE) {
            $query = Sector::getTableName() . ',' . Sector::getPrimaryKey();
        }
        $validator = Validator::make(
            $request->all(['id', 'type']),
            [
                'type' => 'required|in:' . implode(',', Subscription::SUBSCRIPTION_TYPES),
                'id' => 'required|exists:sqlsrv.' . $query
            ]
        );
        $validator->validate();
        $subscription = new Subscription();
        $subscription->subscribable_id = $subscribableId;
        $subscription->subscribable_type = $subscribableType;
        $subscription->user_id = $userId;
        $subscription->save();
        return $this->singleView($subscription, $this->transformerFactory->make(SubscriptionTransformer::class));
    }
}
