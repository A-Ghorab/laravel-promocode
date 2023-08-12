<?php

use AGhorab\LaravelPromocode\Tests\MockModels\User;

use function AGhorab\LaravelPromocode\getPromocodeModel;
use function AGhorab\LaravelPromocode\getPromocodeUsageModel;

it('Model should extends Promocode', function () {
    config()->set('promocodes.models.promocodes.model', User::class);

    getPromocodeModel();
})->throws(Exception::class);

it('Model should extends Promocode Usage', function () {
    config()->set('promocodes.models.promocode_usage_table.model', User::class);

    getPromocodeUsageModel();
})->throws(Exception::class);
