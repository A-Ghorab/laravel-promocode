<?php

namespace AGhorab\LaravelPromocode\Traits;

use AGhorab\LaravelPromocode\Handlers\BaseDiscountHandler;

trait ApplyPromocodeHandler
{
    protected $discountables = [];

    /**
     * @return array<string,array<string,string>>
     */
    public function getDiscountableItems(): array
    {
        return [
            'amount' => [
                'discount' => 'discount',
                'original' => null,
            ],
        ];
    }

    public function applyPromocodeDiscount(BaseDiscountHandler $handler)
    {
        foreach ($this->getDiscountableItems() as $attribute => [$discount, $original]) {
            $originalAmount = $this->{$attribute};

            $amountAfterDiscount = $handler->calculate($originalAmount);

            if ($discount) {
                $this->{$discount} = $originalAmount - $amountAfterDiscount;
            }

            if ($original) {
                $this->{$original} = $originalAmount;
            }

            $this->{$attribute} = $amountAfterDiscount;
        }
    }
}
