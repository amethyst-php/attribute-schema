<?php

namespace Amethyst\AttributeSchemaResolvers;

use Railken\Lem\Attributes\BaseAttribute;

class DataNameResolver extends Resolver
{
    /**
     * Return \Railken\Lem\Attribute\BaseAttribute class.
     *
     * @return string
     */
    public function getSchemaClass(): string
    {
        return \Amethyst\Core\Attributes\DataNameAttribute::class;
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
        // ...
    }

    public function validate()
    {
    }
}
