<?php

namespace Amethyst\Providers;

use Amethyst\Core\Providers\CommonServiceProvider;
use Amethyst\Models\AttributeSchema;
use Amethyst\Observers\AttributeSchemaObserver;

class AttributeSchemaServiceProvider extends CommonServiceProvider
{
    /**
     * @inherit
     */
    public function register()
    {
        parent::register();

        $this->app->singleton('amethyst.attribute-schema', function ($app) {
            return new \Amethyst\Services\Attributable();
        });
        $this->app->register(\Amethyst\Providers\RelationSchemaServiceProvider::class);
    }

    /**
     * @inherit
     */
    public function boot()
    {
        parent::boot();

        AttributeSchema::observe(AttributeSchemaObserver::class);
    }
}
