<?php

namespace AGhorab\LaravelPromocode\Traits;

use AGhorab\LaravelPromocode\Exceptions\PromocodeAlreadyApplied;
use AGhorab\LaravelPromocode\Exceptions\PromocodeNotAllowedForUser;
use AGhorab\LaravelPromocode\Exceptions\PromocodeUsageExceeded;
use AGhorab\LaravelPromocode\Models\Promocode;
use Illuminate\Foundation\Auth\User;

trait HasPromocode
{
    public function applyPromocode(string $code)
    {
        /** @var User */
        $user = $this;

        /** @var Promocode */
        $promocode = getPromocodeModel()::findByCode($code);
        if (! $promocode->allowedForUser($user)) {
            throw new PromocodeNotAllowedForUser($code, $user);
        }

        if (! $promocode->hasUsagesLeft()) {
            throw new PromocodeUsageExceeded($code);
        }

        if (! $promocode->multi_use && $promocode->appliedByUser($user)) {
            throw new PromocodeAlreadyApplied($code, $user);
        }

        $promocodeUsageClass = getPromocodeUsageModel();

        return $promocode->usages()->save(new $promocodeUsageClass([
            config('promocodes.models.promocode_usage_table.user_id_foreign_id') => $user->getAuthIdentifier(),
        ]));
    }
}
