<?php

namespace Amethyst\AttributeSchemaResolvers;

class YamlResolver extends Resolver
{
    /**
     * Return \Railken\Lem\Attributes\BaseAttribute class.
     *
     * @return string
     */
    public function getSchemaClass(): string
    {
        return \Railken\Lem\Attributes\YamlAttribute::class;
    }

    public function validate()
    {
    }
}
