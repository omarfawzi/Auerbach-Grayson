<?php

namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactAnalystValidator
{
    /**
     * @param Request $request
     */
    public function validate(Request $request) : void
    {
        Validator::make($request->all(['dateTime']),[
            'dateTime' => 'required'
        ])->validate();
    }
}
