<?php

namespace Amethyst\AttributeSchemaResolvers;

use Amethyst\Exceptions\AttributeSchemaPayloadInvalidException;
use Railken\Lem\Attributes\BaseAttribute;

class DateResolver extends Resolver
{
    /**
     * Return \Railken\Lem\Attributes\BaseAttribute class
     *
     * @return string
     */
    public function getSchemaClass(): string
    {
        return \Railken\Lem\Attributes\DateAttribute::class;
    }

    public function validate()
    {

    }
}
