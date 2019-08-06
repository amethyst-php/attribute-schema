<?php

namespace Amethyst\Providers;

use Amethyst\Common\CommonServiceProvider;
use Amethyst\Models\Attribute;
use Amethyst\Observers\AttributeObserver;

class AttributeServiceProvider extends CommonServiceProvider
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
        
        app('amethyst.attributable')->boot();

        Attribute::observe(AttributeObserver::class);
    }
}
