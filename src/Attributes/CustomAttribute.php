<?php

namespace Railken\Amethyst\Attributes;

use Railken\Lem\Attributes\TextAttribute as BaseAttribute;

class CustomAttribute extends BaseAttribute
{
    /**
     * Is the attribute fillable.
     *
     * @var bool
     */
    protected $fillable = true;

    /**
     * Is the attribute fillable.
     *
     * @var bool
     */
    protected $required = true;
}
