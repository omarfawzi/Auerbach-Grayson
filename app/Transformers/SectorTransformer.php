<?php

namespace App\Transformers;

use App\Models\SQL\Sector;
use League\Fractal\TransformerAbstract;

class SectorTransformer extends TransformerAbstract
{
    /**
     * @param Sector $sector
     * @return array
     */
    public function transform(Sector $sector): array
    {
        return [
            'id' => $sector->GICS_SectorId,
            'name' => $sector->GICS_Sector
        ];
    }
}
