<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use League\Fractal\TransformerAbstract;
use League\Fractal\Serializer\SerializerAbstract;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

trait ExceptionRenderable
{
    /**
     * Response the exception in JSON.
     *
     * @param Throwable           $throwable
     * @param TransformerAbstract $transformer
     * @param SerializerAbstract  $serializer
     *
     * @return JsonResponse
     */
    public function jsonResponse(Throwable $throwable, TransformerAbstract $transformer, SerializerAbstract $serializer): JsonResponse
    {
        $error = fractal($throwable, new $transformer(), new $serializer)->toArray();

        return response()->json($error)
            ->setStatusCode($this->getStatusCode($error))
            ->withHeaders($this->getHeaders($throwable));
    }

    /**
     * Check if the exception is renderable with JSON
     *
     * @param Throwable $throwable
     * @return bool
     */
    public function isJsonRenderable(Throwable $throwable): bool
    {
        return !(config('app.debug') && $throwable instanceof FatalError);
    }

    /**
     * Get the status code of the exception.
     *
     * @param  array  $error
     *
     * @return int
     */
    public function getStatusCode(array $error): int
    {
        if ($status = Arr::get($error, 'status')) {
            return $status;
        }

        if ($status = Arr::get($error, 'error.status')) {
            return $status;
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    /**
     * Get the headers of the exception.
     *
     * @param Throwable $throwable
     * @return array
     */
    private function getHeaders(Throwable $throwable): array
    {
        if (method_exists($throwable, 'getHeaders')) {
            return $throwable->getHeaders();
        }

        return [];
    }
}
