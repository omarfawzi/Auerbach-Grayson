<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class MessageTransformer extends TransformerAbstract
{
    public function transform(string $message) : array
    {
        return  [
            'message' => $message
        ];
    }
}
