<?php

namespace App\Http\Controllers;

use App\Factories\TransformerFactory;
use App\Repositories\CompanyRepository;
use App\Traits\FractalView;
use App\Transformers\CompanyTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController
{
    use FractalView;

    /** @var CompanyRepository $companyRepository */
    protected $companyRepository;

    /** @var TransformerFactory $transformerFactory */
    protected $transformerFactory;

    /**
     * CompanyController constructor.
     *
     * @param CompanyRepository  $companyRepository
     * @param TransformerFactory $transformerFactory
     */
    public function __construct(CompanyRepository $companyRepository, TransformerFactory $transformerFactory)
    {
        $this->companyRepository  = $companyRepository;
        $this->transformerFactory = $transformerFactory;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $companies = $this->companyRepository->getCompanies(
            $request->get('limit', config('api.defaults.limit'))
        );

        return $this->toJson($this->listView($companies, $this->transformerFactory->make(CompanyTransformer::class)));
    }
}
