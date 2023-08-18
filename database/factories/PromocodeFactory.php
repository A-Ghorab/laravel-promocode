<?php

namespace AGhorab\LaravelPromocode\Database\Factories;

use function AGhorab\LaravelPromocode\getPromocodeTableUserIdFieldName;
use AGhorab\LaravelPromocode\Handlers\DiscountCalculator;
use AGhorab\LaravelPromocode\Models\Promocode;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

/**
 * @extends Factory<Promocode>
 */
class PromocodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model|Promocode>
     */
    protected $model = Promocode::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->text(9),
            'total_usages' => $this->faker->numberBetween(1, 1000),
            'multi_use' => $this->faker->boolean,
        ];
    }

    public function expired(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'expired_at' => now()->subMonth(),
            ];
        });
    }

    public function notExpired(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'expired_at' => now()->addMonth(),
            ];
        });
    }

    public function unlimited(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'total_usages' => null,
            ];
        });
    }

    public function totalUsage(int $totalUsage): Factory
    {
        return $this->state(function (array $attributes) use ($totalUsage) {
            return [
                'total_usages' => $totalUsage,
            ];
        });
    }

    public function singleUse(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'multi_use' => false,
            ];
        });
    }

    public function multiUse(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'multi_use' => true,
            ];
        });
    }

    public function boundedReedemer(User $user): Factory
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                getPromocodeTableUserIdFieldName() => $user->getAuthIdentifier(),
            ];
        });
    }

    public function discount(DiscountCalculator $discountCalculator): Factory
    {
        return $this->state(function (array $attributes) use ($discountCalculator) {
            return [
                'discount_calculator' => $discountCalculator,
            ];
        });
    }
}
