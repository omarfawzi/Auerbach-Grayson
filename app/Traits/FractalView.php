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
     * @param LengthAwarePaginator $lengthAwarePaginator
     * @param TransformerAbstract  $transformerAbstract
     * @return array
     */
    public function listView(
        LengthAwarePaginator $lengthAwarePaginator,
        TransformerAbstract $transformerAbstract
    ): array {
        return fractal($lengthAwarePaginator, $transformerAbstract)->paginateWith(
            new IlluminatePaginatorAdapter($lengthAwarePaginator)
        )->toArray();
    }

    /**
     * @param Model $model
     * @param TransformerAbstract $transformerAbstract
     * @return array
     */
    public function singleView(Model $model, TransformerAbstract $transformerAbstract): array
    {
        return fractal($model, $transformerAbstract)->toArray();
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
