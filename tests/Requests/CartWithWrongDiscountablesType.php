<?php

namespace AGhorab\LaravelPromocode\Tests\Requests;

use AGhorab\LaravelPromocode\Traits\ApplyPromocodeHandler;

class CartWithWrongDiscountablesType
{
    use ApplyPromocodeHandler;

    protected $discountables = 'Wrong Values';
}
