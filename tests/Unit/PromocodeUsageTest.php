<?php

use AGhorab\LaravelPromocode\Models\Promocode;
use AGhorab\LaravelPromocode\Models\PromocodeUsage;
use AGhorab\LaravelPromocode\Tests\MockModels\User;

it('test promocode usage relation', function () {
    User::factory()->count(5)->create();

    $promocode = Promocode::factory()->has(PromocodeUsage::factory()->count(3), 'usages')->multiUse()->totalUsage(3)->createOne();

    expect(PromocodeUsage::query()->first()->promocode->id)->toEqual($promocode->id);
});
