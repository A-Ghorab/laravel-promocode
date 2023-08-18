<?php

namespace AGhorab\LaravelPromocode\Tests\Requests;

use AGhorab\LaravelPromocode\Traits\ApplyPromocodeHandler;

class Cart
{
    public float $discount_amount = 0;

    public float $original_amount = 0;

    use ApplyPromocodeHandler;

    public function __construct(public float $amount)
    {

    }

    protected $discountables = [
        'amount' => [
            'discount' => 'discount_amount',
            'original' => 'original_amount',
        ],
    ];
}
