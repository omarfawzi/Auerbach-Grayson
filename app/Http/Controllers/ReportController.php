<?php

namespace App\Http\Controllers;

use App\Factories\TransformerFactory;
use App\Repositories\ReportRepository;
use App\Transformers\ReportTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

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


    public function index(Request $request)
    {
        $validator = Validator::make(
            $request->all(['type']),
            [
                'type'    => 'required'
            ]
        );

        $validator->validate();

        $reports = $this->reportRepository->getReportsByType($request->get('type'), $request->get('limit'));

        $response = fractal($reports,$this->transformerFactory->make(ReportTransformer::class))->toArray();

        return response()->json($response, Response::HTTP_OK);
    }
}
