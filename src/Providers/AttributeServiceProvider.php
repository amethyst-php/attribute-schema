<?php

namespace Railken\Amethyst\Providers;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Railken\Amethyst\Common\CommonServiceProvider;

class AttributeServiceProvider extends CommonServiceProvider
{
    /**
     * @inherit
     */
    public function register()
    {
        parent::register();

        $this->app->singleton('amethyst.attributable', function ($app) {
            return new \Railken\Amethyst\Services\Attributable();
        });
    }

    /**
     * @inherit
     */
    public function boot()
    {
        parent::boot();

        \Illuminate\Database\Eloquent\Builder::macro('attributeValues', function (): MorphMany {
            return app('amethyst')->createMacroMorphRelation($this, \Railken\Amethyst\Models\AttributeValue::class, 'attributeValues', 'attributable');
        });

        \Illuminate\Database\Eloquent\Builder::macro('attrs', function () {
            return app('amethyst.attributable')->attachAttrsToModel($this);
        });

        app('amethyst.attributable')->boot();
    }
}
