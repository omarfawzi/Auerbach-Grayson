<?php

namespace App\Transformers;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use League\Fractal\TransformerAbstract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ErrorTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Throwable $throwable
     * @return array
     */
    public function transform(Throwable $throwable): array
    {
        $error = [
            'message' => $this->getMessage($throwable),
            'status' => $this->getStatusCode($throwable),
        ];
        if (count($details = $this->getDetails($throwable))) {
            $error['details'] = $details;
        }

        if (config('app.debug')) {
            if (config('app.debug')) {
                $error['debug'] = [
                    'exception' => class_basename($throwable),
                    'trace' => $this->getTrace($throwable),
                ];
            }
        }
        return $error;
    }

    /**
     * Get the message of the exception.
     *
     * @param Throwable $throwable
     * @return string
     */
    protected function getMessage(Throwable $throwable): string
    {
        if (method_exists($throwable, 'getMessage') and ($message = $throwable->getMessage()) != '') {
            return $message;
        }

        switch (true) {
            case $throwable instanceof NotFoundHttpException:
                return "Not found";
        }

        return "Unknown error";
    }

    /**
     * Get the status code of the exception.
     *
     * @param Throwable $throwable
     * @return int
     */
    protected function getStatusCode(Throwable $throwable): int
    {
        if (method_exists($throwable, 'getStatusCode')) {
            return $throwable->getStatusCode();
        }

        if (property_exists($throwable, 'status')) {
            return $throwable->status;
        }

        switch (true) {
            case $throwable instanceof ModelNotFoundException:
            case $throwable instanceof NotFoundHttpException:
                return Response::HTTP_NOT_FOUND;

            case $throwable instanceof ValidationException:
                return Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    /**
     * Get the details of the exception.
     *
     * @param Throwable $throwable
     * @return array
     */
    protected function getDetails(Throwable $throwable): array
    {
        if (method_exists($throwable, 'getDetails')) {
            return $throwable->getDetails();
        }

        if (method_exists($throwable, 'errors')) {
            return $throwable->errors();
        }

        return [];
    }


    /**
     * Get the trace of the exception.
     *
     * @param Throwable $throwable
     * @return array
     */
    protected function getTrace(Throwable $throwable): array
    {
        return preg_split("/\n/", $throwable->getTraceAsString());
    }
}
