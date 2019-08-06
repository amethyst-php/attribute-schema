<?php

namespace Amethyst\Services;

use Amethyst\Managers\AttributeManager;
use Amethyst\Models;
use Railken\Lem\Manager;
use Railken\Lem\Attributes\TextAttribute;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Railken\Lem\Contracts\EntityContract;
use Illuminate\Support\Facades\Schema;

class Attributable
{
    public function boot()
    {
        if (!Schema::hasTable(Config::get('amethyst.attribute.data.attribute.table'))) {
            return;
        }

        Manager::listen('boot', function ($data) {
            $manager = $data->manager;

            $name = app('amethyst')->tableize($manager->getEntity());


            $attributes = Models\Attribute::where(['model' => $name])->get();

            foreach ($attributes as $attributeRaw) {
                $class = config('amethyst.attribute.schema.' . $attributeRaw->schema);
                $attribute = $class::make($attributeRaw->name)->setManager($manager);
                $attribute->boot();
                $manager->addAttribute($attribute);
            }
        });
    }
}
