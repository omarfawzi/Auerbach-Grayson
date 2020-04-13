<?php

namespace App\Transformers;

use App\Models\SQL\Industry;
use League\Fractal\TransformerAbstract;

class IndustryTransformer extends TransformerAbstract
{
    /**
     * @param Industry $industry
     * @return array
     */
    public function transform(Industry $industry): array
    {
        return [
            'id'   => $industry->IndustryID,
            'name' => $industry->Industry,
        ];
    }
}
