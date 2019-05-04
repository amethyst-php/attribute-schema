<?php

namespace Railken\Amethyst\Services;

use Railken\Bag;

class AttributeBag extends Bag
{
	/**
	 * @param string $name
	 * @param mixed $value
	 */
	public function setAttribute(string $name, $value)
	{
		return $this->set($name, $value);
	}

	public function __toString()
	{
		return '';
	}
}