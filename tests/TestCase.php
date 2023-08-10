<?php

namespace AGhorab\LaravelPromocode\Tests;

use AGhorab\LaravelPromocode\PromocodesServiceProvider;
use AGhorab\LaravelPromocode\Tests\MockModels\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * @return string[]
     */
    public function getPackageProviders($application): array
    {
        return [
            PromocodesServiceProvider::class,
        ];
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations();
    }

    protected function getEnvironmentSetUp($application)
    {
        parent::getEnvironmentSetUp($application);
        $application['config']->set('promocodes.models.users.model', User::class);
    }
}
