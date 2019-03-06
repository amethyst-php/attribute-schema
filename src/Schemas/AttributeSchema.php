<?php

namespace Railken\Amethyst\Schemas;

use Illuminate\Support\Facades\Config;
use Railken\Lem\Attributes;
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
                ->setRequired(true),
            Attributes\LongTextAttribute::make('description'),
            Attributes\EnumAttribute::make('schema', array_keys(Config::get('amethyst.attribute.schema')))
                ->setRequired(true),
            Attributes\YamlAttribute::make('options'),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
