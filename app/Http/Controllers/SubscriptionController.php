<?php

namespace App\Http\Controllers;

use App\Factories\TransformerFactory;
use App\Repositories\SubscriptionRepository;
use App\Traits\FractalView;
use App\Transformers\SubscriptionTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @param TransformerFactory     $transformerFactory
     */
    public function __construct(SubscriptionRepository $subscriptionRepository, TransformerFactory $transformerFactory)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->transformerFactory     = $transformerFactory;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        $subscriptions = $this->subscriptionRepository->getSubscriptions($request->user()->id,$request->get('limit', config('api.defaults.limit')));
        return $this->listView($subscriptions, $this->transformerFactory->make(SubscriptionTransformer::class));
    }
}
