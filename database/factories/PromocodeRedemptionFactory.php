<?php

namespace AGhorab\LaravelPromocode\Database\Factories;

use function AGhorab\LaravelPromocode\getPromocodeRedemptionTableUserIdField;
use AGhorab\LaravelPromocode\Models\PromocodeRedemption;
use AGhorab\LaravelPromocode\Tests\MockModels\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as AuthUser;

/**
 * @extends Factory<PromocodeRedemption>
 */
class PromocodeRedemptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model|PromocodeRedemption>
     */
    protected $model = PromocodeRedemption::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            getPromocodeRedemptionTableUserIdField() => User::all()->random()->getAuthIdentifier(),
        ];
    }

    public function forUser(AuthUser $user): Factory
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                getPromocodeRedemptionTableUserIdField() => $user->getAuthIdentifier(),
            ];
        });
    }
}
