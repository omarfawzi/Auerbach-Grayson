<?php

namespace App\Http\Controllers;

use App\Factories\TransformerFactory;
use App\Repositories\ReportRepository;
use App\Repositories\ReportViewRepository;
use App\Services\MailService;
use App\Traits\FractalView;
use App\Transformers\ReportDetailTransformer;
use App\Transformers\ReportTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ReportController
{
    use FractalView;

    /** @var ReportRepository $reportRepository */
    protected $reportRepository;

    /** @var ReportViewRepository $reportViewRepository */
    protected $reportViewRepository;

    /** @var TransformerFactory $transformerFactory */
    protected $transformerFactory;

    /** @var MailService $mailService */
    protected $mailService;

    /**
     * ReportController constructor.
     *
     * @param ReportRepository         $reportRepository
     * @param ReportViewRepository     $reportViewRepository
     * @param TransformerFactory       $transformerFactory
     * @param MailService              $mailService
     */
    public function __construct(
        ReportRepository $reportRepository,
        ReportViewRepository $reportViewRepository,
        TransformerFactory $transformerFactory,
        MailService $mailService
    ) {
        $this->reportRepository         = $reportRepository;
        $this->reportViewRepository     = $reportViewRepository;
        $this->transformerFactory       = $transformerFactory;
        $this->mailService              = $mailService;
    }


    /**
     * @OA\Get(
     *     path="/reports",
     *     summary="Get Reports",
     *     tags={"Reports"},
     *     @OA\Parameter(in="query",name="pagination",@OA\Schema(ref="#/components/schemas/ListParams")),
     *     @OA\Parameter(in="query",name="type",required=false,@OA\Schema(type="string")),
     *     @OA\Parameter(in="query",name="trending",required=false,@OA\Schema(type="boolean")),
     *     @OA\Parameter(in="query",name="recommended",required=false,@OA\Schema(type="boolean")),
     *     @OA\Parameter(in="query",name="saved",required=false,@OA\Schema(type="boolean")),
     *     @OA\Parameter(in="query",name="searchKey",required=false,@OA\Schema(type="string")),
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
     *           @OA\Property(property="data",ref="#/components/schemas/ReportDetail")
     *        )
     *      )
     *    ),
     *    @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Property(ref="#/components/schemas/NotFoundException")
     *        )
     *    )
     * )
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request , int $id): JsonResponse
    {
        $report = $this->reportRepository->getReport($id);

        $this->reportViewRepository->store($request->user()->id, $id);

        return $this->singleView($report, $this->transformerFactory->make(ReportDetailTransformer::class));
    }
}
