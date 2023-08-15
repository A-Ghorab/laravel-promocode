<?php

use AGhorab\LaravelPromocode\Handlers\PercentageDiscountHandler;

it('expect 10% discount on 100', function () {
    $calculator = new PercentageDiscountHandler(10);

    expect($calculator->calculate(100))->toEqual(90);
});
