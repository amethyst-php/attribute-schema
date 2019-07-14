<?php

namespace Amethyst\Managers;

use Amethyst\Common\ConfigurableManager;
use Railken\Lem\Manager;

/**
 * @method \Amethyst\Models\Attribute newEntity()
 * @method \Amethyst\Schemas\AttributeSchema getSchema()
 * @method \Amethyst\Repositories\AttributeRepository getRepository()
 * @method \Amethyst\Serializers\AttributeSerializer getSerializer()
 * @method \Amethyst\Validators\AttributeValidator getValidator()
 * @method \Amethyst\Authorizers\AttributeAuthorizer getAuthorizer()
 */
class AttributeManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.attribute.data.attribute';
}
