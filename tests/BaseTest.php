<?php

namespace Amethyst\Tests;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');

        app('amethyst.attributable')->boot();
    }

    protected function getPackageProviders($app)
    {
        return [
            \Amethyst\Providers\FooServiceProvider::class,
            \Amethyst\Providers\AttributeSchemaServiceProvider::class,
        ];
    }
}
