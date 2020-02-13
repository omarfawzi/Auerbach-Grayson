<?php

namespace App\Http\Controllers;

use App\Factories\TransformerFactory;
use App\Repositories\ReportRepository;
use App\Transformers\ReportTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ReportController
{
    /** @var ReportRepository $reportRepository */
    private $reportRepository;

    /** @var TransformerFactory $transformerFactory */
    private $transformerFactory;

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
    public function index(Request $request) : JsonResponse
    {
        $reports = $this->reportRepository->getReports(
            $request->get('type'),
            $request->get('limit') ?? 15,
            $request->get('page') ?? 1
        );

        $response = fractal($reports,$this->transformerFactory->make(ReportTransformer::class))->toArray();

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id) : JsonResponse
    {
        $report = $this->reportRepository->getReportById($id);

        $response = fractal($report,$this->transformerFactory->make(ReportTransformer::class))->toArray();

        return response()->json($response, Response::HTTP_OK);
    }
}
