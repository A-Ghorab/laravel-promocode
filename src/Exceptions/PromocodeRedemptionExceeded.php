<?php

namespace AGhorab\LaravelPromocode\Exceptions;

class PromocodeRedemptionExceeded extends PromocodeBaseValidation
{
    public function __construct(string $code)
    {
        parent::__construct(__('The code :code has exceed the max usage', [
            'code' => $code,
        ]));
    }
}
