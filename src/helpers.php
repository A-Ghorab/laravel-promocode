<?php

use AGhorab\LaravelPromocode\Models\Promocode;
use AGhorab\LaravelPromocode\Models\PromocodeUsage;

if (! function_exists('getPromocodeModel')) {
    /**
     * @return class-string<Promocode>
     */
    function getPromocodeModel()
    {
        $promoCodeClass = config('promocodes.models.promocodes.model');
        if (! is_a($promoCodeClass, Promocode::class, true)) {
            throw new Exception("Class doesn't extend Promocode Model");
        }

        return $promoCodeClass;
    }
}

if (! function_exists('getPromocodeUsageModel')) {
    /**
     * @return class-string<PromocodeUsage>
     */
    function getPromocodeUsageModel()
    {
        $promocodeUsageClass = config('promocodes.models.promocode_usage_table.model');

        if (! is_a($promocodeUsageClass, PromocodeUsage::class, true)) {
            throw new Exception("Class doesn't extend Promocode Usage Model");
        }

        return $promocodeUsageClass;
    }
}
