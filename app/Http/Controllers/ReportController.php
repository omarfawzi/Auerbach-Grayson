<?php

namespace App\Http\Controllers;

use App\Factories\TransformerFactory;
use App\Repositories\ReportRepository;
use App\Traits\FractalView;
use App\Transformers\ReportTransformer;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ReportController
{
    use FractalView;

    /** @var ReportRepository $reportRepository */
    protected $reportRepository;

    /** @var TransformerFactory $transformerFactory */
    protected $transformerFactory;

    /**
     * ReportController constructor.
     *
     * @param ReportRepository   $reportRepository
     * @param TransformerFactory $transformerFactory
     */
    public function __construct(ReportRepository $reportRepository, TransformerFactory $transformerFactory)
    {
        $this->reportRepository   = $reportRepository;
        $this->transformerFactory = $transformerFactory;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $reports = $this->reportRepository->getReports(
            $request->get('limit', config('api.defaults.limit')),
            $request->all()
        );

        return $this->listView($reports, $this->transformerFactory->make(ReportTransformer::class));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $report = $this->reportRepository->getReportById($id);

        return $this->singleView($report, $this->transformerFactory->make(ReportTransformer::class));
    }
}
