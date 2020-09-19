<?php

namespace Amethyst\AttributeSchemaResolvers;

use Amethyst\Exceptions\AttributeSchemaPayloadInvalidException;
use Railken\Lem\Attributes\BaseAttribute;

class TextResolver extends Resolver
{
    /**
     * Return \Railken\Lem\Attributes\TextAttribute class
     *
     * @return string
     */
    public function getSchemaClass(): string
    {
        return \Railken\Lem\Attributes\TextAttribute::class;
    }

    public function validate()
    {

    }
}
