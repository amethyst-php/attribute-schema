<?php

namespace Amethyst\AttributeSchemaResolvers;

use Amethyst\Exceptions\AttributeSchemaPayloadInvalidException;
use Railken\Lem\Attributes\BaseAttribute;

class EnumResolver extends Resolver
{
    /**
     * Return \Railken\Lem\Attributes\BaseAttribute class.
     *
     * @return string
     */
    public function getSchemaClass(): string
    {
        return \Railken\Lem\Attributes\EnumAttribute::class;
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
        if (empty($options->options)) {
            throw new AttributeSchemaPayloadInvalidException($attributeSchema);
        }

        $attribute->setOptions($options->options);
    }

    public function validate()
    {
    }
}
