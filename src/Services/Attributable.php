<?php

namespace Amethyst\Services;

use Amethyst\Models;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Railken\Lem\Manager;

class Attributable
{
    protected $attributes;

    public function reload()
    {
        $this->attributes = Models\AttributeSchema::all();
    }

    public function boot()
    {
        if (!Schema::hasTable(Config::get('amethyst.attribute-schema.data.attribute-schema.table'))) {
            return;
        }

        $this->reload();

        Manager::listen('boot', function ($data) {
            $manager = $data->manager;

            $name = $manager->getName();

            $attributes = $this->attributes->filter(function ($attribute) use ($name) {
                return $attribute->model === strtolower($name);
            });

            foreach ($attributes as $attribute) {
                $attribute->getResolver()->boot($manager);
            }
        });
    }

    public function getAttributes()
    {
        return $this->attributes;
    }
}
