<?php

namespace Amethyst\Exceptions;

use Amethyst\Models\AttributeSchema;
use Exception;

class AttributeSchemaPayloadInvalidException extends Exception
{
    public function __construct(AttributeSchema $attributeSchema, $message = '')
    {
        parent::__construct(sprintf(
            'Something went wrong while initializing the attribute schema id %s. Payload used: `%s`. %s',
            $attributeSchema->id,
            $attributeSchema->options,
            $message
        ));
    }
}
