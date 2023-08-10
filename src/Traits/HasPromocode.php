<?php

namespace AGhorab\LaravelPromocode\Traits;

use AGhorab\LaravelPromocode\Models\Promocode;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

trait HasPromocode
{
    public function applyPromocodeForCurrentUser(string $code)
    {
        return $this->applyPromocode($code, Auth::authenticate());
    }

    public function applyPromocode(string $code, Authenticatable $user)
    {
        /** @var Promocode */
        $promocode = getPromocodeModel()::findByCode($code);
        if (! $promocode->allowedForUser($user)) {
            throw new Exception('Not Allowed for user');
        }

        if (! $promocode->hasUsagesLeft()) {
            throw new Exception('No Usage Left');
        }

        if (! $promocode->multi_use && $promocode->appliedByUser($user)) {
            throw new Exception('User already applied for them');
        }

        $promocodeUsageClass = getPromocodeUsageModel();

        return $promocode->usages()->save(new $promocodeUsageClass([
            config('promocodes.models.promocode_usage_table.user_id_foreign_id') => $user->getAuthIdentifier(),
        ]));
    }
}
