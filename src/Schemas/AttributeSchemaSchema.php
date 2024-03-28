<?php

namespace Amethyst\Schemas;

use Illuminate\Support\Facades\Config;
use Railken\Lem\Attributes;
use Railken\Lem\Contracts\EntityContract;
use Railken\Lem\Schema;
use Symfony\Component\Yaml\Yaml;

class AttributeSchemaSchema extends Schema
{
    /**
     * Get all the attributes.
     *
     * @var array
     */
    public function getAttributes()
    {
        return [
            Attributes\IdAttribute::make(),
            \Amethyst\Core\Attributes\DataNameAttribute::make('model')
                ->setRequired(true)
                ->setMutable(false),
            Attributes\TextAttribute::make('name')
                ->setRequired(true)
                ->setValidator(function (EntityContract $entity, $value) {
                    return preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $value);
                }),
            Attributes\LongTextAttribute::make('description'),
            Attributes\EnumAttribute::make('schema', array_keys(Config::get('amethyst.attribute-schema.resolvers')))
                ->setRequired(true),
            Attributes\BooleanAttribute::make('required')
                ->setDefault(function (EntityContract $entity) {
                    return false;
                }),
            Attributes\TextAttribute::make('regex')
                ->setRequired(false)
                ->setValidator(function (EntityContract $entity, $value) {
                    try {
                        return preg_match($value, null) !== false;
                    } catch (\Throwable $exception) {
                        return false;
                    }
                }),
            Attributes\YamlAttribute::make('options')
                ->setValidator(function (EntityContract $entity, $value) {
                    // $options = (object) Yaml::parse((string) $attributeRaw->options);

                    return true;
                }),
            Attributes\TextAttribute::make('require')
                ->setFillable(false)
                ->setMutable(false),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
