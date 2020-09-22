<?php

namespace Amethyst\Exceptions;

use Exception;

class RequireDependencyException extends Exception
{
	public function __construct($message)
	{
		parent::__construct($message);
	}
}