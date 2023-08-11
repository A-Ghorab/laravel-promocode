<?php

namespace AGhorab\LaravelPromocode\Exceptions;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class PromocodeBaseValidation extends ValidationException
{
    public function __construct(string $message)
    {
        // Empty data and rules
        $validator = Validator::make([], []);

        // Add fields and errors
        $validator->errors()->add('code', $message);

        parent::__construct($validator);
    }
}
