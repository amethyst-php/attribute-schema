<?php

namespace Railken\Amethyst\Services;

use Railken\Bag;

class AttributeBag extends Bag
{
    public function __toString()
    {
        return '';
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function setAttribute(string $name, $value)
    {
        return $this->set($name, $value);
    }
}
