<?php

use function AGhorab\LaravelPromocode\getBoundedUserModelName;
use function AGhorab\LaravelPromocode\getPromocodeModel;
use function AGhorab\LaravelPromocode\getPromocodeTableName;
use function AGhorab\LaravelPromocode\getPromocodeTableUserIdFieldName;
use function AGhorab\LaravelPromocode\getPromocodeUsageModel;
use function AGhorab\LaravelPromocode\getPromocodeUsageTable;
use function AGhorab\LaravelPromocode\getPromocodeUsageTablePromocodeIdField;
use function AGhorab\LaravelPromocode\getPromocodeUsageTableUserIdField;
use function AGhorab\LaravelPromocode\getScalarValue;

use AGhorab\LaravelPromocode\Models\Promocode;
use AGhorab\LaravelPromocode\Tests\MockModels\User;

it('Model should extends Promocode', function () {
    config()->set('promocodes.models.promocodes.model', User::class);

    getPromocodeModel();
})->throws(Exception::class);

it('Model should extends Promocode Usage', function () {
    config()->set('promocodes.models.promocode_usage_table.model', User::class);

    getPromocodeUsageModel();
})->throws(Exception::class);

it('Model should extends User', function () {
    config()->set('promocodes.models.users.model', Promocode::class);

    getBoundedUserModelName();
})->throws(Exception::class);

it('Promocodes Table name should be string', function () {
    config()->set('promocodes.models.promocodes.table_name', 123);

    getPromocodeTableName();
})->throws(Exception::class);

it('Promocode Usage Table name should be string', function () {
    config()->set('promocodes.models.promocode_usage_table.table_name', 123);

    getPromocodeUsageTable();
})->throws(Exception::class);

it('Promocode Table User id field name', function () {
    config()->set('promocodes.models.promocodes.bound_to_user_id_foreign_id', 123);

    getPromocodeTableUserIdFieldName();
})->throws(Exception::class);

it('Promocode Usage Table User id field name', function () {
    config()->set('promocodes.models.promocode_usage_table.user_id_foreign_id', 123);

    getPromocodeUsageTableUserIdField();
})->throws(Exception::class);

it('Promocode Usage Table Promocode id field name', function () {
    config()->set('promocodes.models.promocode_usage_table.promocode_foreign_id', 123);

    getPromocodeUsageTablePromocodeIdField();
})->throws(Exception::class);

it('GetScalar would throw an error if an array is sent', function () {
    getScalarValue([]);
})->throws(Exception::class);
