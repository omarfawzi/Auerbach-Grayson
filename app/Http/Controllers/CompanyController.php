<?php

namespace App\Http\Controllers;

use App\Factories\TransformerFactory;
use App\Repositories\CompanyRepository;
use App\Transformers\CompanyTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Http\Request;

class CompanyController
{
    /** @var CompanyRepository $companyRepository */
    private $companyRepository;

    /** @var TransformerFactory $transformerFactory */
    private $transformerFactory;

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

        $response = fractal($companies, $this->transformerFactory->make(CompanyTransformer::class))->paginateWith(
            new IlluminatePaginatorAdapter($companies)
        )->toArray();

        return response()->json($response, Response::HTTP_OK);
    }
}
