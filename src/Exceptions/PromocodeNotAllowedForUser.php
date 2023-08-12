<?php

namespace AGhorab\LaravelPromocode\Exceptions;

use function AGhorab\LaravelPromocode\getScalarValue;
use Illuminate\Contracts\Auth\Authenticatable;

class PromocodeNotAllowedForUser extends PromocodeBaseValidation
{
    public function __construct(string $code, Authenticatable $user)
    {
        parent::__construct(__("The code :code isn't allowed for user :user", [
            'code' => $code,
            'user' => getScalarValue($user->getAuthIdentifier()),
        ]));
    }
}
