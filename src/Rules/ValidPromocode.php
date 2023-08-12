<?php

namespace AGhorab\LaravelPromocode\Rules;

use function AGhorab\LaravelPromocode\getPromocodeModel;
use function AGhorab\LaravelPromocode\getScalarValue;
use AGhorab\LaravelPromocode\Models\Promocode;
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
        if (! is_string($code)) {
            $fail(__('validation.string', compact('attribute')));
        } else {
            /** @var Promocode */
            $promocode = getPromocodeModel()::findByCode($code);

            $user = $this->user;

            if ($promocode->isExpired()) {
                $fail(__('The code :code is expired', compact('code')));
            } elseif ($user && ! $promocode->allowedForUser($user)) {
                $fail(__("The code :code isn't allowed for user :user", [
                    'code' => $code,
                    'user' => getScalarValue($user->getKey()),
                ]));
            } elseif (! $promocode->hasUsagesLeft()) {
                $fail(__('The code :code has exceed the max usage', compact('code')));
            } elseif ($user && ! $promocode->multi_use && $promocode->appliedByUser($user)) {
                $fail(__('The code :code is already applied', [
                    'code' => $code,
                    'user' => getScalarValue($user->getKey()),
                ]));
            }
        }
    }
}
