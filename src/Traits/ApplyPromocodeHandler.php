<?php

namespace AGhorab\LaravelPromocode\Traits;

use AGhorab\LaravelPromocode\Handlers\DiscountCalculator;
use UnexpectedValueException;

trait ApplyPromocodeHandler
{
    public function applyPromocodeDiscount(DiscountCalculator $handler)
    {
        if (! is_array($this->discountables)) {
            throw new UnexpectedValueException('discountables field not array');
        }
        foreach ($this->discountables as $key => $value) {
            if (is_string($key)) {
                $attribute = $key;
                ['discount' => $discount, 'original' => $original] = $value;
            } else {
                $attribute = $value;
                $discount = null;
                $original = null;
            }

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
