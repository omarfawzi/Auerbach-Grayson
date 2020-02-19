<?php

namespace App\Transformers;

use App\Dto\Output\RegionDto;
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
        return (new RegionDto($region->RegionId, $region->Region))->toArray();
    }
}
