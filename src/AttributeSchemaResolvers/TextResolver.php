<?php

namespace Amethyst\AttributeSchemaResolvers;

use Amethyst\Exceptions\AttributeSchemaPayloadInvalidException;
use Railken\Lem\Attributes\BaseAttribute;

class TextResolver extends Resolver
{
    public function getSchemaClass(): string
    {
        return \Railken\Lem\Attributes\TextAttribute::class;
    }

    public function validate()
    {

    }
}
