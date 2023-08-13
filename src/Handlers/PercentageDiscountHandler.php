<?php

namespace AGhorab\LaravelPromocode\Handlers;

class PercentageDiscountHandler extends BaseDiscountHandler
{
    public function __construct(private readonly float $percentage)
    {
    }

    public function calculate(float $value): float
    {
        return (100 - $this->percentage) * $value / 100;
    }
}
