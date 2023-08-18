<?php

namespace AGhorab\LaravelPromocode\Handlers;

class PercentageDiscountHandler implements DiscountCalculator
{
    public function __construct(private readonly float $percentage)
    {
    }

    public function calculate(float $value): float
    {
        return (100 - $this->percentage) * $value / 100;
    }
}
