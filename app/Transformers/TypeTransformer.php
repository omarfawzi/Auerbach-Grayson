<?php

namespace App\Transformers;

use App\Models\SQL\Type;
use League\Fractal\TransformerAbstract;

class TypeTransformer extends TransformerAbstract
{
    public function transform(Type $type)
    {
        return $type->toArray();
    }
}
