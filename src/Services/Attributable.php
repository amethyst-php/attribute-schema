<?php

namespace Amethyst\Services;

use Amethyst\Models;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Railken\Lem\Manager;
use Symfony\Component\Yaml\Yaml;
use Amethyst\Exceptions\AttributeSchemaPayloadInvalidException;

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

            $attributes = $this->attributes->filter(function ($attribute) use ($name) { return $attribute->model === strtolower($name); });

            foreach ($attributes as $attributeRaw) {

                $class = config('amethyst.attribute-schema.schema.'.$attributeRaw->schema);
                $attribute = $class::make($attributeRaw->name)->setManager($manager);

                $attribute->setRequired($attributeRaw->required);

                $options = (object) Yaml::parse((string) $attributeRaw->options);

                if (!empty($attributeRaw->regex)) {
                    $attribute->setValidator(function ($entity, $value) use ($attributeRaw) {
                        return preg_match($attributeRaw->regex, $value);
                    });
                }

                if (!empty($options)) {

                    if ($attributeRaw->schema === 'BelongsTo') {
                        if (empty($options->relationName) || empty($options->relationData)) {
                            throw new AttributeSchemaPayloadInvalidException($attributeRaw);
                        }

                        $attribute->setRelationName($options->relationName);
                        $attribute->setRelationManager(app('amethyst')->findManagerByName($options->relationData));
                        
                    }

                    if ($attributeRaw->schema === 'Enum') {
                        if (empty($options->options)) {
                            throw new AttributeSchemaPayloadInvalidException($attributeRaw);
                        }
                        
                        $attribute->setOptions($options->options);
                        
                    }

                    if ($attributeRaw->schema === 'Number') {
                        if (!empty($options->precision)) {
                            $attribute->setPrecision($options->precision);
                        }

                        if (!empty($options->scale)) {
                            $attribute->setScale($options->scale);
                        }
                    }
                }

                $attribute->boot();

                $manager->addAttribute($attribute);
            }
        });
    }
}
