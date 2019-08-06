<?php

namespace Amethyst\Schemas;

use Illuminate\Support\Facades\Config;
use Railken\Lem\Attributes;
use Railken\Lem\Schema;
use Railken\Lem\Contracts\EntityContract;

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
                ->setRequired(true),
            Attributes\LongTextAttribute::make('description'),
            Attributes\EnumAttribute::make('schema', array_keys(Config::get('amethyst.attribute.schema')))
                ->setRequired(true),
            Attributes\YamlAttribute::make('options'),
            Attributes\TextAttribute::make('model', app('amethyst')->getData()->keys()->toArray())
                ->setRequired(true),
            Attributes\BooleanAttribute::make('nullable')
                ->setDefault(function (EntityContract $entity) {
                    return true;
                }),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
