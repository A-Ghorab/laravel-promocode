<?php

namespace AGhorab\LaravelPromocode\Tests\MockModels;

use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model|Cart>
     */
    protected $model = Cart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount' => $this->faker->randomFloat(min: 1, max : 1000),
        ];
    }

    public function amount(float $amount)
    {
        return $this->state(function (array $attributes) use ($amount) {
            return [
                'amount' => $amount,
            ];
        });
    }
}
