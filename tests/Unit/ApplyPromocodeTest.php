<?php

use AGhorab\LaravelPromocode\Exceptions\PromocodeAlreadyApplied;
use AGhorab\LaravelPromocode\Exceptions\PromocodeNotAllowedForUser;
use AGhorab\LaravelPromocode\Exceptions\PromocodeUsageExceeded;
use AGhorab\LaravelPromocode\Models\Promocode;
use AGhorab\LaravelPromocode\Models\PromocodeUsage;
use AGhorab\LaravelPromocode\Tests\MockModels\User;

it('Promocode Bounded to another user', function () {
    /** @var User */
    [$user, $otherUser] = User::factory()->count(2)->create();

    /** @var Promocode */
    $promocode = Promocode::factory()->singleUse()->boundedUser($user)->createOne();
    $otherUser->applyPromocode($promocode->code);
})->throws(PromocodeNotAllowedForUser::class);

it('Promocode Usage Exceeded', function () {
    /** @var Promocode */
    $promocode = Promocode::factory()->has(PromocodeUsage::factory()->forUser(User::factory()->createOne())->count(1), 'usages')->singleUse()->totalUsage(1)->createOne();

    /** @var User */
    $user = User::factory()->createOne();

    $user->applyPromocode($promocode->code);
})->throws(PromocodeUsageExceeded::class);

it('Promocode Already Applied', function () {
    /** @var Promocode */
    $promocode = Promocode::factory()->singleUse()->totalUsage(2)->createOne();

    /** @var User */
    $user = User::factory()->createOne();

    $user->applyPromocode($promocode->code);

    $user->applyPromocode($promocode->code);

})->throws(PromocodeAlreadyApplied::class);
