<?php

namespace App\Http\Controllers;

use App\Factories\TransformerFactory;
use App\Repositories\SectorRepository;
use App\Traits\FractalView;
use App\Transformers\SectorTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        $sectors = $this->sectorRepository->getSectors($request->get('limit', config('api.defaults.limit')));

        return $this->toJson($this->listView($sectors, $this->transformerFactory->make(SectorTransformer::class)));
    }
}
