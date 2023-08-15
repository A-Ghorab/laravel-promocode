<?php

namespace AGhorab\LaravelPromocode\Handlers;

interface DiscountCalculator
{
    public function calculate(float $value): float;
}
