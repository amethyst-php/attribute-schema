<?php

namespace Amethyst\Schemas;

use Illuminate\Support\Facades\Config;
use Railken\Lem\Attributes;
use Railken\Lem\Contracts\EntityContract;
use Railken\Lem\Schema;

class AttributeSchema extends Schema
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
            Attributes\TextAttribute::make('name')
                ->setRequired(true)
                ->setValidator(function (EntityContract $entity, $value) {
                    return preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $value);
                }),
            Attributes\LongTextAttribute::make('description'),
            Attributes\EnumAttribute::make('schema', array_keys(Config::get('amethyst.attribute.schema')))
                ->setRequired(true),
            Attributes\TextAttribute::make('regex')
                ->setRequired(false)
                ->setValidator(function (EntityContract $entity, $value) {
                    try {
                        return preg_match($value, null) !== false;
                    } catch (\Throwable $exception) {
                        return false;
                    }
                }),
            Attributes\YamlAttribute::make('options'),
            \Amethyst\Core\Attributes\DataNameAttribute::make('model')
                ->setRequired(true),
            Attributes\BooleanAttribute::make('required')
                ->setDefault(function (EntityContract $entity) {
                    return false;
                }),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
