<?php

namespace Amethyst\AttributeSchemaResolvers;

use Amethyst\Exceptions\AttributeSchemaPayloadInvalidException;
use Railken\Lem\Attributes\BaseAttribute;

class BelongsToResolver extends Resolver
{
    /**
     * Return \Railken\Lem\Attribute\BaseAttribute class.
     *
     * @return string
     */
    public function getSchemaClass(): string
    {
        return \Railken\Lem\Attributes\BelongsToAttribute::class;
    }

    /**
     * Load additional options for the attribute.
     *
     * @param BaseAttribute $attribute
     * @param \stdClass     $options
     *
     * @return void
     */
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
