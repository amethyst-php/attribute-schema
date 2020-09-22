<?php

namespace Amethyst\AttributeSchemaResolvers;

class DateResolver extends Resolver
{
    /**
     * Return \Railken\Lem\Attributes\BaseAttribute class.
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
