<?php

namespace Amethyst\AttributeSchemaResolvers;

use Amethyst\Exceptions\AttributeSchemaPayloadInvalidException;
use Railken\Lem\Attributes\BaseAttribute;

class LongTextResolver extends Resolver
{
    public function getSchemaClass(): string
    {
        return \Railken\Lem\Attributes\LongTextAttribute::class;
    }

    public function validate()
    {

    }
}
