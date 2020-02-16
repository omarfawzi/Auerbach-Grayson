<?php

namespace App\Http\Controllers;

use App\Factories\TransformerFactory;
use App\Repositories\RegionRepository;
use App\Traits\FractalView;
use App\Transformers\RegionTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegionController
{
    use FractalView;

    /** @var TransformerFactory $transformerFactory */
    protected $transformerFactory;

    /** @var RegionRepository $regionRepository */
    protected $regionRepository;

    /**
     * RegionController constructor.
     *
     * @param TransformerFactory $transformerFactory
     * @param RegionRepository   $regionRepository
     */
    public function __construct(TransformerFactory $transformerFactory, RegionRepository $regionRepository)
    {
        $this->transformerFactory = $transformerFactory;
        $this->regionRepository   = $regionRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        $regions = $this->regionRepository->getRegions($request->get('limit', config('api.defaults.limit')));

        return $this->listView($regions,$this->transformerFactory->make(RegionTransformer::class));
    }
}
