<?php

namespace AGhorab\LaravelPromocode;

use AGhorab\LaravelPromocode\Models\Promocode;
use AGhorab\LaravelPromocode\Models\PromocodeUsage;

/**
 * @return class-string<Promocode>
 */
function getPromocodeModel()
{
    /** @var class-string<Promocode> */
    $promoCodeClass = config('promocodes.models.promocodes.model');

    if (! is_a($promoCodeClass, Promocode::class, true)) {
        throw new \Exception("Class doesn't extend Promocode Model");
    }

    return $promoCodeClass;
}

/**
 * @return class-string<PromocodeUsage>
 */
function getPromocodeUsageModel()
{
    /** @var class-string<PromocodeUsage> */
    $promocodeUsageClass = config('promocodes.models.promocode_usage_table.model');

    if (! is_a($promocodeUsageClass, PromocodeUsage::class, true)) {
        throw new \Exception("Class doesn't extend Promocode Usage Model");
    }

    return $promocodeUsageClass;
}

function getPromocodeUsageTable(): string
{
    return config('promocodes.models.promocode_usage_table.table_name');
}

function getPromocodeUsageTableUserIdField(): string
{
    return config('promocodes.models.promocode_usage_table.user_id_foreign_id');
}
