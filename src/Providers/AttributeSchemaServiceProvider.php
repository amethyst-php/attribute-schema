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

        $this->app->singleton('amethyst.attributable', function ($app) {
            return new \Amethyst\Services\Attributable();
        });
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
