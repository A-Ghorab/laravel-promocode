<?php

namespace AGhorab\LaravelPromocode\Exceptions;

use Illuminate\Contracts\Auth\Authenticatable;

class PromocodeAlreadyApplied extends PromocodeBaseValidation
{
    public function __construct(string $code, Authenticatable $user)
    {
        parent::__construct(__('The code :code is already applied', [
            'code' => $code,
            'user' => $user->getAuthIdentifier(),
        ]));
    }
}
