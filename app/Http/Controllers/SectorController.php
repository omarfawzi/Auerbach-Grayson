<?php

namespace App\Http\Controllers;

use App\Factories\TransformerFactory;
use App\Repositories\SectorRepository;
use App\Traits\FractalView;
use App\Transformers\SectorTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class SectorController
{
    use FractalView;

    /** @var SectorRepository $sectorRepository */
    protected $sectorRepository;

    /** @var TransformerFactory $transformerFactory */
    protected $transformerFactory;

    /**
     * SectorController constructor.
     *
     * @param SectorRepository   $sectorRepository
     * @param TransformerFactory $transformerFactory
     */
    public function __construct(SectorRepository $sectorRepository, TransformerFactory $transformerFactory)
    {
        $this->sectorRepository   = $sectorRepository;
        $this->transformerFactory = $transformerFactory;
    }

    /**
     * @OA\Get(
     *     path="/sectors",
     *     summary="Get Sectors",
     *     tags={"Sectors"},
     *     @OA\Parameter(in="query",name="pagination",@OA\Schema(ref="#/components/schemas/ListParams")),
     *     @OA\Response(
     *        response="200",
     *        description="Get Sectors",
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *            @OA\Property(property="data", ref="#/components/schemas/SectorDto"),
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
        $sectors = $this->sectorRepository->getSectors($request->get('limit', config('api.defaults.limit')));

        return $this->listView($sectors, $this->transformerFactory->make(SectorTransformer::class));
    }
}
