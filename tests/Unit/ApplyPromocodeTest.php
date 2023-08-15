<?php

use AGhorab\LaravelPromocode\Exceptions\PromocodeAlreadyApplied;
use AGhorab\LaravelPromocode\Exceptions\PromocodeExpired;
use AGhorab\LaravelPromocode\Exceptions\PromocodeNotAllowedForUser;
use AGhorab\LaravelPromocode\Exceptions\PromocodeRedemptionExceeded;
use AGhorab\LaravelPromocode\Models\Promocode;
use AGhorab\LaravelPromocode\Models\PromocodeRedemption;
use AGhorab\LaravelPromocode\Tests\MockModels\User;

it('Promocode Bounded to another user', function () {
    /** @var User */
    [$user, $otherUser] = User::factory()->count(2)->create();

    /** @var Promocode */
    $promocode = Promocode::factory()->singleUse()->boundedReedemer($user)->createOne();
    $otherUser->applyPromocode($promocode->code);
})->throws(PromocodeNotAllowedForUser::class);

it('Promocode Usage Exceeded', function () {
    /** @var Promocode */
    $promocode = Promocode::factory()->has(PromocodeRedemption::factory()->forUser(User::factory()->createOne())->count(1), 'redemptions')->singleUse()->totalUsage(1)->createOne();

    /** @var User */
    $user = User::factory()->createOne();

    $user->applyPromocode($promocode->code);
})->throws(PromocodeRedemptionExceeded::class);

it('Promocode Already Applied', function () {
    /** @var Promocode */
    $promocode = Promocode::factory()->singleUse()->totalUsage(2)->createOne();

    /** @var User */
    $user = User::factory()->createOne();

    $user->applyPromocode($promocode->code);

    $user->applyPromocode($promocode->code);

})->throws(PromocodeAlreadyApplied::class);

it('Promocode Already Expired', function () {
    /** @var Promocode */
    $promocode = Promocode::factory()->singleUse()->totalUsage(2)->expired()->createOne();

    /** @var User */
    $user = User::factory()->createOne();

    $user->applyPromocode($promocode->code);

})->throws(PromocodeExpired::class);

it('Access Promocode from User', function () {
    $user = User::factory()->createOne();

    /** @var Promocode */
    Promocode::factory()->has(PromocodeRedemption::factory()->forUser($user)->count(1), 'redemptions')->singleUse()->totalUsage(1)->createOne();

    expect($user->promocodes()->count())->toEqual(1);
});
