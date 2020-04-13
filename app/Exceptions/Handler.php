<?php

namespace App\Exceptions;

use App\Traits\ExceptionRenderable;
use App\Transformers\ErrorTransformer;
use App\Serializers\ErrorSerializer;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ExceptionRenderable;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];


    /**
     * Render an exception into an HTTP response.
     *
     * @param Request   $request
     * @param Throwable $throwable
     * @return Response
     * @throws Throwable
     */
    public function render($request, Throwable $throwable): Response
    {
        if ($this->isJsonRenderable($request, $throwable)) {
            return $this->jsonResponse($throwable, new ErrorTransformer(), new ErrorSerializer());
        }

        return parent::render($request, $throwable);
    }
}
