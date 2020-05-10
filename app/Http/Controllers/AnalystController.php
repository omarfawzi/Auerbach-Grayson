<?php


namespace App\Http\Controllers;


use App\Factories\TransformerFactory;
use App\Models\SQL\Report;
use App\Repositories\ReportRepository;
use App\Services\MailService;
use App\Traits\FractalView;
use App\Transformers\MessageTransformer;
use App\Validators\ContactAnalystValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

class AnalystController
{
    use FractalView;

    /** @var ReportRepository $reportRepository */
    protected $reportRepository;

    /** @var MailService $mailService */
    protected $mailService;

    /** @var TransformerFactory $transformerFactory */
    protected $transformerFactory;

    /** @var ContactAnalystValidator $contactAnalystValidator */
    protected $contactAnalystValidator;

    /**
     * AnalystController constructor.
     *
     * @param ReportRepository        $reportRepository
     * @param MailService             $mailService
     * @param TransformerFactory      $transformerFactory
     * @param ContactAnalystValidator $contactAnalystValidator
     */
    public function __construct(
        ReportRepository $reportRepository,
        MailService $mailService,
        TransformerFactory $transformerFactory,
        ContactAnalystValidator $contactAnalystValidator
    ) {
        $this->reportRepository = $reportRepository;
        $this->mailService = $mailService;
        $this->transformerFactory = $transformerFactory;
        $this->contactAnalystValidator = $contactAnalystValidator;
    }


    /**
     * @OA\Post(
     *     path="/reports/{id}/analysts/contact",
     *     summary="Contact Analyst",
     *     tags={"Reports"},
     *     @OA\RequestBody(
     *        @OA\MediaType(mediaType="application/json",@OA\Schema(ref="#/components/schemas/ContactAnalystInput"))
     *     ),
     *     @OA\Parameter(in="path",name="id",required=true,@OA\Schema(type="number")),
     *     @OA\Response(
     *        response="200",
     *        description="Contact Analyst",
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
     *     )
     *    )
     * )
     * @param Request $request
     * @param int     $id
     * @return JsonResponse
     */
    public function contact(Request $request, int $id) : JsonResponse
    {
        $this->contactAnalystValidator->validate($request);

        $report = $this->reportRepository->getReport($id);

        if ($report instanceof Report) {
            $this->mailService->email(
                [],
                env('ANALYST_MAIL_CC'),
                $report->analysts->toArray(),
                view('email.contact_analyst')->with(
                    [
                        'dateTime' => $request->get('dateTime'),
                        'link'     => $request->get('link'),
                        'message'  => $request->get('message'),
                    ]
                )
            );
        }

        return $this->singleView(
            'Email sent successfully',
            $this->transformerFactory->make(MessageTransformer::class)
        );
    }

    /**
     * @OA\Post(
     *     path="/reports/{id}/analysts/email",
     *     summary="Email Analyst",
     *     tags={"Reports"},
     *     @OA\Parameter(in="path",name="id",required=true,@OA\Schema(type="number")),
     *     @OA\Response(
     *        response="200",
     *        description="Contact Analyst",
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
     *     )
     *    )
     * )
     * @param int $id
     * @return JsonResponse
     */
    public function email(int $id) : JsonResponse
    {
        $report = $this->reportRepository->getReport($id);

        if ($report instanceof Report) {
            $this->mailService->email([], env('ANALYST_MAIL_CC'), $report->analysts->toArray(), view('email.email_analyst'));
        }

        return $this->singleView(
            'Email sent successfully',
            $this->transformerFactory->make(MessageTransformer::class)
        );
    }

}
