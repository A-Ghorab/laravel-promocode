<?php

namespace AGhorab\LaravelPromocode\Database\Factories;

use AGhorab\LaravelPromocode\Models\Promocode;
use AGhorab\LaravelPromocode\Models\PromocodeUsage;
use AGhorab\LaravelPromocode\Tests\MockModels\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as AuthUser;

use function AGhorab\LaravelPromocode\getPromocodeUsageTableUserIdField;

/**
 * @extends Factory<PromocodeUsage>
 */
class PromocodeUsageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model|PromocodeUsage>
     */
    protected $model = PromocodeUsage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // config('promocodes.models.promocode_usage_table.promocode_foreign_id') => Promocode::factory()->create()->getKey(),
            getPromocodeUsageTableUserIdField() => User::all()->random()->getAuthIdentifier(),
        ];
    }

    public function forUser(AuthUser $user): Factory
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                getPromocodeUsageTableUserIdField() => $user->getAuthIdentifier(),
            ];
        });
    }
}
