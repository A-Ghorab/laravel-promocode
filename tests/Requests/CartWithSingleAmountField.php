<?php

namespace AGhorab\LaravelPromocode\Tests\Requests;

use AGhorab\LaravelPromocode\Traits\ApplyPromocodeHandler;

class CartWithSingleAmountField
{
    use ApplyPromocodeHandler;

    public function __construct(public float $amount)
    {

    }

    protected $discountables = ['amount'];
}
