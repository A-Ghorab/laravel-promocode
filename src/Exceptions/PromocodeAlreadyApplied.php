<?php

namespace AGhorab\LaravelPromocode\Exceptions;

use function AGhorab\LaravelPromocode\getScalarValue;
use Illuminate\Contracts\Auth\Authenticatable;

class PromocodeAlreadyApplied extends PromocodeBaseValidation
{
    public function __construct(string $code, Authenticatable $user)
    {
        parent::__construct(__('The code :code is already applied', [
            'code' => $code,
            'user' => getScalarValue($user->getAuthIdentifier()),
        ]));
    }
}
