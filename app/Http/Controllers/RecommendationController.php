<?php

namespace App\Http\Controllers;

use App\Factories\TransformerFactory;
use App\Repositories\RecommendationRepository;
use App\Traits\FractalView;
use App\Transformers\RecommendationTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class RecommendationController
{
    use FractalView;

    /** @var RecommendationRepository $recommendationRepository */
    protected $recommendationRepository;

    /** @var TransformerFactory $transformerFactory */
    protected $transformerFactory;

    /**
     * RecommendationController constructor.
     *
     * @param RecommendationRepository $recommendationRepository
     * @param TransformerFactory       $transformerFactory
     */
    public function __construct(
        RecommendationRepository $recommendationRepository,
        TransformerFactory $transformerFactory
    ) {
        $this->recommendationRepository = $recommendationRepository;
        $this->transformerFactory       = $transformerFactory;
    }


    /**
     * @OA\Get(
     *     path="/recommendations",
     *     summary="Get Recommendations",
     *     tags={"Recommendations"},
     *     @OA\Parameter(in="query",name="pagination",@OA\Schema(ref="#/components/schemas/ListParams")),
     *     @OA\Response(
     *        response="200",
     *        description="Get Recommendations",
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *            @OA\Property(property="data",type="array",@OA\Items(type="object",ref="#/components/schemas/Recommendation")),
     *            @OA\Property(property="meta", ref="#/components/schemas/Meta")
     *        )
     *      )
     *    )
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        $recommendations = $this->recommendationRepository->getRecommendations($request->get('limit', config('api.defaults.limit')));

        return $this->listView($recommendations,$this->transformerFactory->make(RecommendationTransformer::class));
    }
}
