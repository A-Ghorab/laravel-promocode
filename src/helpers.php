<?php

namespace AGhorab\LaravelPromocode;

use AGhorab\LaravelPromocode\Models\Promocode;
use AGhorab\LaravelPromocode\Models\PromocodeUsage;
use Exception;
use Illuminate\Foundation\Auth\User;

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

function getPromocodeTableName(): string
{
    $tableName = config('promocodes.models.promocodes.table_name');

    if (! is_string($tableName)) {
        throw new \Exception("Table name isn't string");
    }

    return $tableName;
}

function getPromocodeTableUserIdFieldName(): string
{
    $tableName = config('promocodes.models.promocodes.bound_to_user_id_foreign_id');

    if (! is_string($tableName)) {
        throw new \Exception("Table name isn't string");
    }

    return $tableName;
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

/**
 * @return class-string<PromocodeUsage>
 */
function getBoundedUserModelName()
{
    /** @var class-string<PromocodeUsage> */
    $userClass = config('promocodes.models.users.model');

    if (! is_a($userClass, User::class, true)) {
        throw new \Exception("Class doesn't extend User Model");
    }

    return $userClass;
}

function getPromocodeUsageTable(): string
{
    $tableName = config('promocodes.models.promocode_usage_table.table_name');

    if (! is_string($tableName)) {
        throw new \Exception("Table name isn't string");
    }

    return $tableName;
}

function getPromocodeUsageTableUserIdField(): string
{
    $foreignId = config('promocodes.models.promocode_usage_table.user_id_foreign_id');

    if (! is_string($foreignId)) {
        throw new \Exception("Foreign name isn't string");
    }

    return $foreignId;
}

function getPromocodeUsageTablePromocodeIdField(): string
{
    $foreignId = config('promocodes.models.promocode_usage_table.promocode_foreign_id');

    if (! is_string($foreignId)) {
        throw new \Exception("Foreign name isn't string");
    }

    return $foreignId;
}

function getScalarValue(mixed $item): bool|float|int|string
{
    if (! is_string($item) && ! is_bool($item) && ! is_float($item) && ! is_int($item)) {
        throw new Exception("Item isn't scalar");
    }

    return $item;
}
