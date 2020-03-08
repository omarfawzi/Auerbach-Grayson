<?php

namespace App\Transformers;

use App\Models\SQL\Recommendation;
use League\Fractal\TransformerAbstract;

class RecommendationTransformer extends TransformerAbstract
{
    /**
     * @param Recommendation $recommendation
     * @return array
     */
    public function transform(Recommendation $recommendation) : array
    {
        return  $recommendation->toArray();
    }
}
