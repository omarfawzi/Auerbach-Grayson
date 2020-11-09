<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\TransformerAbstract;

trait FractalView
{

    /**
     * @param LengthAwarePaginator $data
     * @param TransformerAbstract  $transformerAbstract
     * @return JsonResponse
     */
    public function listView(
        LengthAwarePaginator $data,
        TransformerAbstract $transformerAbstract
    ): JsonResponse {
        return $this->toJson(
            fractal($data, $transformerAbstract)->paginateWith(
                new IlluminatePaginatorAdapter($data)
            )->toArray()
        );
    }

    /**
     * @param Model|string        $model
     * @param TransformerAbstract $transformerAbstract
     * @return JsonResponse
     */
    public function singleView($model, TransformerAbstract $transformerAbstract): JsonResponse
    {
        return $this->toJson(fractal($model, $transformerAbstract)->toArray());
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function toJson(array $data): JsonResponse
    {
        return response()->json($data, Response::HTTP_OK);
    }
}
