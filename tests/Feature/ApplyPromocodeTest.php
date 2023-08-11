<?php

use AGhorab\LaravelPromocode\Models\Promocode;
use AGhorab\LaravelPromocode\Tests\MockModels\User;

it('test user can apply on promocode', function () {
    /** @var User */
    $user = User::factory()->createOne();
    /** @var Promocode */
    $promocode = Promocode::factory()->singleUse()->totalUsage(3)->createOne();

    $user->applyPromocode($promocode->code);

    expect($promocode->usages()->count())->toEqual(1);
});
