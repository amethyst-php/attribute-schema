<?php

namespace Amethyst\AttributeSchemaResolvers;

use Amethyst\Exceptions\AttributeSchemaPayloadInvalidException;
use Railken\Lem\Attributes\BaseAttribute;

class BooleanResolver extends Resolver
{
    /**
     * Return \Railken\Lem\Attributes\BaseAttribute class
     *
     * @return string
     */
    public function getSchemaClass(): string
    {
        return \Railken\Lem\Attributes\BooleanAttribute::class;
    }

    public function validate()
    {

    }
}
