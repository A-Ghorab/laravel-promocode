<?php

namespace AGhorab\LaravelPromocode\Handlers;

use AGhorab\LaravelPromocode\Traits\ApplyPromocodeHandler;
use Exception;
use Illuminate\Database\Eloquent\Model;

class PercentageDiscountHandler extends BaseDiscountHandler
{
    public function __construct(private readonly float $percentage)
    {
    }

    public function calculate(float $value): float
    {
        return (100 - $this->percentage) * $value / 100;
    }

    public function handle(Model $model)
    {
        if (! in_array(ApplyPromocodeHandler::class, class_uses_recursive($model))) {
            throw new Exception("Model doesn't have Apply Promocode Handler");
        }

        /** @var ApplyPromocodeHandler */
        $handler = $model;
        foreach ($handler->getDiscountableItems() as $attribute => [$discount, $original]) {
            $originalAmount = $model->{$attribute};

            $discountAmount = ($originalAmount * $this->percentage) / 100;

            if ($discount) {
                $model->{$discount} = $discountAmount;
            }

            if ($original) {
                $model->{$original} = $originalAmount;
            }

            $model->{$attribute} = $originalAmount - $discountAmount;
        }

        $model->save();
    }
}
