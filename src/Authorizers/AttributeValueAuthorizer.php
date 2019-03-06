<?php

namespace Railken\Amethyst\Authorizers;

use Railken\Lem\Authorizer;
use Railken\Lem\Tokens;

class AttributeValueAuthorizer extends Authorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'attribute-value.create',
        Tokens::PERMISSION_UPDATE => 'attribute-value.update',
        Tokens::PERMISSION_SHOW   => 'attribute-value.show',
        Tokens::PERMISSION_REMOVE => 'attribute-value.remove',
    ];
}
