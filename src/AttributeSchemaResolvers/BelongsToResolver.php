<?php

namespace Amethyst\AttributeSchemaResolvers;

use Railken\Lem\Attributes\TextAttribute as BaseAttribute;
use Amethyst\Exceptions\AttributeSchemaPayloadInvalidException;
use Railken\Lem\Attributes\BaseAttribute;

class BelongsToResolver extends Resolver
{
    public function getSchemaClass(): string
    {
        return \Railken\Lem\Attributes\BelongsToAttribute::class;
    }

    public function loadOptions(BaseAttribute $attribute, \stdClass $options)
    {
        if (empty($options->relationName) || empty($options->relationData)) {
            throw new AttributeSchemaPayloadInvalidException($this->attributeSchema);
        }

        $attribute->setRelationName($options->relationName);
        $attribute->setRelationManager(app('amethyst')->findManagerByName($options->relationData));
    }

    public function callDatabaseOptions($column)
    {
        $column->unsigned();
    }

    public function validate()
    {

    }
}
