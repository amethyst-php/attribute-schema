<?php

namespace Amethyst\AttributeSchemaResolvers;

use Amethyst\Exceptions\AttributeSchemaPayloadInvalidException;
use Railken\Lem\Attributes\BaseAttribute;

class EnumResolver extends Resolver
{
    public function getSchemaClass(): string
    {
        return \Railken\Lem\Attributes\EnumAttribute::class;
    }

    public function loadOptions(BaseAttribute $attribute, \stdClass $options)
    {
        if (empty($options->options)) {
            throw new AttributeSchemaPayloadInvalidException($attributeSchema);
        }
        
        $attribute->setOptions($options->options);
    }
    
    public function validate()
    {

    }
}
