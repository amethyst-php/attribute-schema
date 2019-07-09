<?php

namespace Amethyst\Authorizers;

use Railken\Lem\Authorizer;
use Railken\Lem\Tokens;

class AttributableAuthorizer extends Authorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'attributable.create',
        Tokens::PERMISSION_UPDATE => 'attributable.update',
        Tokens::PERMISSION_SHOW   => 'attributable.show',
        Tokens::PERMISSION_REMOVE => 'attributable.remove',
    ];
}
