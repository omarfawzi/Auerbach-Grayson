<?php

namespace App\Transformers;

use App\Models\SQL\Country;

class CountryTransformer
{
    public function transform(Country $country)
    {
        return [
            'id' => $country->CountryID,
            'name' => $country->Country
        ];
    }
}
