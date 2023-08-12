<?php

namespace AGhorab\LaravelPromocode\Traits;

use AGhorab\LaravelPromocode\Exceptions\PromocodeAlreadyApplied;
use AGhorab\LaravelPromocode\Exceptions\PromocodeExpired;
use AGhorab\LaravelPromocode\Exceptions\PromocodeNotAllowedForUser;
use AGhorab\LaravelPromocode\Exceptions\PromocodeUsageExceeded;
use function AGhorab\LaravelPromocode\getPromocodeModel;
use function AGhorab\LaravelPromocode\getPromocodeUsageModel;
use function AGhorab\LaravelPromocode\getPromocodeUsageTable;
use function AGhorab\LaravelPromocode\getPromocodeUsageTableUserIdField;
use AGhorab\LaravelPromocode\Models\Promocode;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User;

trait HasPromocode
{
    public function promocodes(): BelongsToMany
    {
        return $this->belongsToMany(getPromocodeModel(), getPromocodeUsageTable(), getPromocodeUsageTableUserIdField());
    }

    public function applyPromocode(string $code)
    {
        /** @var User */
        $user = $this;

        /** @var Promocode */
        $promocode = getPromocodeModel()::findByCode($code);

        if ($promocode->isExpired()) {
            throw new PromocodeExpired($code);
        }

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
            getPromocodeUsageTableUserIdField() => $user->getAuthIdentifier(),
        ]));
    }
}
