<?php

use AGhorab\LaravelPromocode\Models\Promocode;
use AGhorab\LaravelPromocode\Models\PromocodeRedemption;
use AGhorab\LaravelPromocode\Tests\MockModels\User;

it('test promocode usage relation', function () {
    User::factory()->count(5)->create();

    $promocode = Promocode::factory()->has(PromocodeRedemption::factory()->count(3), 'redemptions')->multiUse()->totalUsage(3)->createOne();

    expect(PromocodeRedemption::query()->first()->promocode->id)->toEqual($promocode->id);
});
