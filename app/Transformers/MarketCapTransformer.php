<?php

namespace App\Transformers;

use App\Models\SQL\MarketCap;
use League\Fractal\TransformerAbstract;

class MarketCapTransformer extends TransformerAbstract
{

    /**
     * @param MarketCap $marketCap
     * @return array
     */
    public function transform(MarketCap $marketCap): array
    {
        return [
            'id'   => $marketCap->MarketCapId,
            'name' => $marketCap->Description
        ];
    }
}
