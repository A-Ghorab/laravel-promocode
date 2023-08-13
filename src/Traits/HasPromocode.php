<?php

namespace AGhorab\LaravelPromocode\Traits;

use AGhorab\LaravelPromocode\Exceptions\PromocodeAlreadyApplied;
use AGhorab\LaravelPromocode\Exceptions\PromocodeExpired;
use AGhorab\LaravelPromocode\Exceptions\PromocodeNotAllowedForUser;
use AGhorab\LaravelPromocode\Exceptions\PromocodeRedemptionExceeded;
use function AGhorab\LaravelPromocode\getPromocodeModel;
use function AGhorab\LaravelPromocode\getPromocodeRedemptionModel;
use function AGhorab\LaravelPromocode\getPromocodeRedemptionTable;
use function AGhorab\LaravelPromocode\getPromocodeRedemptionTableUserIdField;
use AGhorab\LaravelPromocode\Models\Promocode;
use AGhorab\LaravelPromocode\Models\PromocodeRedemption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User;

trait HasPromocode
{
    public function promocodes(): BelongsToMany
    {
        return $this->belongsToMany(getPromocodeModel(), getPromocodeRedemptionTable(), getPromocodeRedemptionTableUserIdField());
    }

    public function applyPromocode(string $code, Model $item = null)
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
            throw new PromocodeRedemptionExceeded($code);
        }

        if (! $promocode->multi_use && $promocode->appliedByUser($user)) {
            throw new PromocodeAlreadyApplied($code, $user);
        }

        $promocodeUsageClass = getPromocodeRedemptionModel();

        /** @var PromocodeRedemption */
        $redemption = new $promocodeUsageClass([
            getPromocodeRedemptionTableUserIdField() => $user->getAuthIdentifier(),
        ]);

        if ($item) {
            $redemption->redeemedItems()->associate($item);
        }

        return $promocode->redemptions()->save($redemption);
    }
}
