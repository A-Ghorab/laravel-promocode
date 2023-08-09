<?php

use AGhorab\LaravelPromocode\Models\Promocode;

it('should return available promocodes', function () {
    Promocode::factory()->expired()->count(5)->create();
    Promocode::factory()->notExpired()->count(5)->create();

    expect(Promocode::available()->count())->toEqual(5);
});