<?php

namespace Amethyst\Exceptions;

use Exception;
use Amethyst\Models\AttributeSchema;

class AttributeSchemaPayloadInvalidException extends Exception
{
	public function __construct(AttributeSchema $attributeSchema)
	{
		parent::__construct(sprintf(
			"Something went wrong while initializing the attribute schema id %s. Payload used: `%s`", 
			$attributeSchema->id, 
			$attributeSchema->options
		));
	}
}