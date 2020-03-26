<?php

namespace App\Transformers;

use App\Models\SQL\Region;
use League\Fractal\TransformerAbstract;

class RegionTransformer extends TransformerAbstract
{
    /**
     * @param Region $region
     * @return array
     */
    public function transform(Region $region) : array
    {
        return [
            'id' => $region->RegionId,
            'name' => $region->Region
        ];
    }
}
