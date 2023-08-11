<?php

namespace AGhorab\LaravelPromocode\Exceptions;

class PromocodeExpired extends PromocodeBaseValidation
{
    public function __construct(string $code)
    {
        parent::__construct(__('The code :code is expired', [
            'code' => $code,
        ]));
    }
}
