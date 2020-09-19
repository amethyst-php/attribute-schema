<?php

namespace Amethyst\AttributeSchemaResolvers;

use Amethyst\Exceptions\AttributeSchemaPayloadInvalidException;
use Railken\Lem\Attributes\BaseAttribute;

class DateTimeResolver extends Resolver
{
    public function getSchemaClass(): string
    {
        return \Railken\Lem\Attributes\DateTimeAttribute::class;
    }

    public function validate()
    {

    }
}
