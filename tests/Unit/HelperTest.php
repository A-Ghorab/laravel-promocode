<?php

use function AGhorab\LaravelPromocode\getboundedReedemerModelName;
use function AGhorab\LaravelPromocode\getPromocodeModel;
use function AGhorab\LaravelPromocode\getPromocodeRedemptionModel;
use function AGhorab\LaravelPromocode\getPromocodeRedemptionTable;
use function AGhorab\LaravelPromocode\getPromocodeRedemptionTablePromocodeIdField;
use function AGhorab\LaravelPromocode\getPromocodeRedemptionTableUserIdField;
use function AGhorab\LaravelPromocode\getPromocodeTableName;
use function AGhorab\LaravelPromocode\getPromocodeTableUserIdFieldName;
use function AGhorab\LaravelPromocode\getScalarValue;
use AGhorab\LaravelPromocode\Models\Promocode;
use AGhorab\LaravelPromocode\Tests\MockModels\User;

it('Model should extends Promocode', function () {
    config()->set('promocodes.models.promocodes.model', User::class);

    getPromocodeModel();
})->throws(Exception::class);

it('Model should extends Promocode Usage', function () {
    config()->set('promocodes.models.promocode_redemption_table.model', User::class);

    getPromocodeRedemptionModel();
})->throws(Exception::class);

it('Model should extends User', function () {
    config()->set('promocodes.models.users.model', Promocode::class);

    getboundedReedemerModelName();
})->throws(Exception::class);

it('Promocodes Table name should be string', function () {
    config()->set('promocodes.models.promocodes.table_name', 123);

    getPromocodeTableName();
})->throws(Exception::class);

it('Promocode Usage Table name should be string', function () {
    config()->set('promocodes.models.promocode_redemption_table.table_name', 123);

    getPromocodeRedemptionTable();
})->throws(Exception::class);

it('Promocode Table User id field name', function () {
    config()->set('promocodes.models.promocodes.bound_to_user_id_foreign_id', 123);

    getPromocodeTableUserIdFieldName();
})->throws(Exception::class);

it('Promocode Usage Table User id field name', function () {
    config()->set('promocodes.models.promocode_redemption_table.user_id_foreign_id', 123);

    getPromocodeRedemptionTableUserIdField();
})->throws(Exception::class);

it('Promocode Usage Table Promocode id field name', function () {
    config()->set('promocodes.models.promocode_redemption_table.promocode_foreign_id', 123);

    getPromocodeRedemptionTablePromocodeIdField();
})->throws(Exception::class);

it('GetScalar would throw an error if an array is sent', function () {
    getScalarValue([]);
})->throws(Exception::class);
