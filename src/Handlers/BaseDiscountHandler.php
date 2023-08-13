<?php

namespace AGhorab\LaravelPromocode\Handlers;

use Illuminate\Queue\SerializesModels;

abstract class BaseDiscountHandler
{
    use SerializesModels;

    abstract public function calculate(float $value): float;
}
