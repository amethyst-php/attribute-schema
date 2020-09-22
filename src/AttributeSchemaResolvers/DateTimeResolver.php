<?php

namespace Amethyst\AttributeSchemaResolvers;

class DateTimeResolver extends Resolver
{
    /**
     * Return \Railken\Lem\Attributes\BaseAttribute class.
     *
     * @return string
     */
    public function getSchemaClass(): string
    {
        return \Railken\Lem\Attributes\DateTimeAttribute::class;
    }

    public function validate()
    {
    }
}
