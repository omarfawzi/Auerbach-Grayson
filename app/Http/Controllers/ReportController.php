<?php

namespace App\Http\Controllers;

use App\Factories\TransformerFactory;
use App\Repositories\ReportRepository;
use App\Traits\FractalView;
use App\Transformers\ReportTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

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
     * @OA\Get(
     *     path="/reports",
     *     summary="Get Reports",
     *     tags={"Reports"},
     *     @OA\Parameter(in="query",name="pagination",@OA\Schema(ref="#/components/schemas/ListParams")),
     *     @OA\Parameter(in="query",name="type",required=false,@OA\Schema(type="string")),
     *     @OA\Parameter(in="query",name="title",required=false,@OA\Schema(type="string")),
     *     @OA\Parameter(in="query",name="date",required=false,@OA\Schema(type="string"),example="today,week,month,year,all"),
     *     @OA\Parameter(in="query",name="country[]",required=false,@OA\Schema(type="array",@OA\Items(type="string"))),
     *     @OA\Parameter(in="query",name="company[]",required=false,@OA\Schema(type="array",@OA\Items(type="string"))),
     *     @OA\Parameter(in="query",name="recommendation[]",required=false,@OA\Schema(type="array",@OA\Items(type="string"))),
     *     @OA\Parameter(in="query",name="sector[]",required=false,@OA\Schema(type="array",@OA\Items(type="string"))),
     *     @OA\Response(
     *        response="200",
     *        description="Get Reports",
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *            @OA\Property(property="data",type="array",@OA\Items(type="object",ref="#/components/schemas/Report")),
     *            @OA\Property(property="meta", ref="#/components/schemas/Meta")
     *        )
     *      )
     *    )
     * )
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
     * @OA\Get(
     *     path="/reports/{id}",
     *     summary="Get Report",
     *     tags={"Reports"},
     *     @OA\Parameter(in="path",name="id",required=true,@OA\Schema(type="number")),
     *     @OA\Response(
     *        response="200",
     *        description="Get Report",
     *        @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *           @OA\Property(property="data",ref="#/components/schemas/Report")
     *        )
     *      )
     *    )
     * )
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $report = $this->reportRepository->getReport($id);

        return $this->singleView($report, $this->transformerFactory->make(ReportTransformer::class));
    }
}
