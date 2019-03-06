<?php

namespace Railken\Amethyst\Authorizers;

use Railken\Lem\Authorizer;
use Railken\Lem\Tokens;

class AttributeAuthorizer extends Authorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'attribute.create',
        Tokens::PERMISSION_UPDATE => 'attribute.update',
        Tokens::PERMISSION_SHOW   => 'attribute.show',
        Tokens::PERMISSION_REMOVE => 'attribute.remove',
    ];
}
