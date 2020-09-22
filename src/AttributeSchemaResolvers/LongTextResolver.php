<?php

namespace Amethyst\AttributeSchemaResolvers;

class LongTextResolver extends Resolver
{
    /**
     * Return \Railken\Lem\Attributes\BaseAttribute class.
     *
     * @return string
     */
    public function getSchemaClass(): string
    {
        return \Railken\Lem\Attributes\LongTextAttribute::class;
    }

    public function validate()
    {
    }
}
