<?php

namespace AGhorab\LaravelPromocode\Tests;

use AGhorab\LaravelPromocode\PromocodesServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations('sqlite');
    }
    
    /**
     * @return string[]
     */
    public function getPackageProviders($application): array
    {
        return [
            PromocodesServiceProvider::class,
        ];
    }
}
