<?php

namespace AGhorab\LaravelPromocode\Tests\MockModels;

use AGhorab\LaravelPromocode\Traits\ApplyPromocodeHandler;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    use ApplyPromocodeHandler;

    protected static function newFactory()
    {
        return new CartFactory();
    }

    protected $discountables = [
        'amount' => [
            'discount' => 'discount_amount',
            'original' => 'original_amount',
        ],
    ];
}
