<?php

namespace Amethyst\Tests;

abstract class BaseTestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');

        app('amethyst.attribute-schema')->boot();
        app('eloquent.mapper')->boot();
    }

    protected function getPackageProviders($app)
    {
        return [
            \Amethyst\Providers\FooServiceProvider::class,
            \Amethyst\Providers\AttributeSchemaServiceProvider::class,
        ];
    }
}
