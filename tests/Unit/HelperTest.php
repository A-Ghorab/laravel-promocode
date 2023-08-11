<?php

use AGhorab\LaravelPromocode\Tests\MockModels\User;

it('Model should extends Promocode', function () {
    config()->set('promocodes.models.promocodes.model', User::class);

    getPromocodeModel();
})->throws(Exception::class);

it('Model should extends Promocode Usage', function () {
    config()->set('promocodes.models.promocode_usage_table.model', User::class);

    getPromocodeUsageModel();
})->throws(Exception::class);
