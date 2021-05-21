<?php

namespace App\Http\Controllers;

use App\Factories\TransformerFactory;
use App\Repositories\SavedReportRepository;
use App\Traits\FractalView;
use App\Transformers\MessageTransformer;
use App\Validators\SavedReportValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class SavedReportController
{
    use FractalView;

    /** @var SavedReportRepository $savedReportRepository */
    protected $savedReportRepository;

    /** @var SavedReportValidator $savedReportValidator */
    protected $savedReportValidator;

    /** @var TransformerFactory $transformerFactory */
    protected $transformerFactory;

    /**
     * SavedReportController constructor.
     *
     * @param SavedReportRepository $savedReportRepository
     * @param SavedReportValidator  $savedReportValidator
     * @param TransformerFactory    $transformerFactory
     */
    public function __construct(
        SavedReportRepository $savedReportRepository,
        SavedReportValidator $savedReportValidator,
        TransformerFactory $transformerFactory
    ) {
        $this->savedReportRepository = $savedReportRepository;
        $this->savedReportValidator  = $savedReportValidator;
        $this->transformerFactory    = $transformerFactory;
    }


    /**
     * @OA\Post(
     *     path="/reports/{id}/save",
     *     summary="Save Report",
     *     tags={"Reports"},
     *     @OA\Parameter(in="path",name="id",required=true,@OA\Schema(type="number")),
     *     @OA\Response(
     *        response="200",
     *        description="Save Report",
     *        @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *             @OA\Property(property="data",ref="#/components/schemas/Message")
     *          )
     *       )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Property(ref="#/components/schemas/NotFoundException")
     *        )
     *    )
     * )
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function save(Request $request, $id): JsonResponse
    {
        $userId = $request->user()->id;
        $this->savedReportValidator->validate($id, $userId);
        $this->savedReportRepository->saveReport($id, $userId);

        return $this->singleView(
            'Saved Successfully',
            $this->transformerFactory->make(MessageTransformer::class)
        );
    }


    /**
     * @OA\Delete(
     *     path="/reports/{id}/unsave",
     *     summary="Unsave Report",
     *     tags={"Reports"},
     *     @OA\Parameter(in="path",name="id",required=true,@OA\Schema(type="number")),
     *     @OA\Response(
     *        response="200",
     *        description="Unsave Report",
     *        @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *             @OA\Property(property="data",ref="#/components/schemas/Message")
     *          )
     *       )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Property(ref="#/components/schemas/NotFoundException")
     *        )
     *    )
     * )
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function unsave(Request $request, int $id): JsonResponse
    {
        $userId = $request->user()->id;
        $this->savedReportRepository->deleteReport($id, $userId);

        return $this->singleView(
            'Unsaved Successfully',
            $this->transformerFactory->make(MessageTransformer::class)
        );
    }
}
