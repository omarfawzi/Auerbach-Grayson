<?php

namespace App\Http\Controllers;

use App\Factories\TransformerFactory;
use App\Repositories\TypeRepository;
use App\Traits\FractalView;
use App\Transformers\TypeTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class TypeController
{
    use FractalView;

    /** @var TypeRepository $typeRepository */
    protected $typeRepository;

    /** @var TransformerFactory $transformerFactory */
    protected $transformerFactory;

    /**
     * TypeController constructor.
     *
     * @param TypeRepository     $typeRepository
     * @param TransformerFactory $transformerFactory
     */
    public function __construct(TypeRepository $typeRepository, TransformerFactory $transformerFactory)
    {
        $this->typeRepository     = $typeRepository;
        $this->transformerFactory = $transformerFactory;
    }

    /**
     * @OA\Get(
     *     path="/types",
     *     summary="Get Types",
     *     tags={"Types"},
     *     @OA\Parameter(in="query",name="pagination",@OA\Schema(ref="#/components/schemas/ListParams")),
     *     @OA\Response(
     *        response="200",
     *        description="Get Types",
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *            @OA\Property(property="data",type="array",@OA\Items(type="object",ref="#/components/schemas/Type")),
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
        $sectors = $this->typeRepository->getTypes($request->get('limit', config('api.defaults.limit')));

        return $this->listView($sectors, $this->transformerFactory->make(TypeTransformer::class));
    }
}
