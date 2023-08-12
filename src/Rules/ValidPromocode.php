<?php

namespace AGhorab\LaravelPromocode\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Auth\User;

class ValidPromocode implements ValidationRule
{
    public function __construct(private ?User $user = null)
    {
        
    }
    public function validate(string $attribute, mixed $code, Closure $fail): void
    {
        if (!is_string($code)) {
            $fail(__("validation.string", compact('attribute')));
        } else {
            /** @var Promocode */
            $promocode = getPromocodeModel()::findByCode($code);

            $user = $this->user;

            if ($promocode->isExpired()) {
                $fail(__('The code :code is expired', compact('code')));
            }else if ($user && ! $promocode->allowedForUser($user)) {
                $fail(__("The code :code isn't allowed for user :user", [
                    'code' => $code,
                    'user' => $user->getKey()
                ]));
            } else if (!$promocode->hasUsagesLeft()) {
                $fail(__('The code :code has exceed the max usage', compact('code')));
            }else if ( $user && ! $promocode->multi_use && $promocode->appliedByUser($user)) {
                $fail(__('The code :code is already applied', compact('code', 'user')));
            }
        }
    }
}
