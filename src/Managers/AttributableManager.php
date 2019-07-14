<?php

namespace Amethyst\Managers;

use Amethyst\Common\ConfigurableManager;
use Railken\Lem\Manager;

/**
 * @method \Amethyst\Models\Attributable newEntity()
 * @method \Amethyst\Schemas\AttributableSchema getSchema()
 * @method \Amethyst\Repositories\AttributableRepository getRepository()
 * @method \Amethyst\Serializers\AttributableSerializer getSerializer()
 * @method \Amethyst\Validators\AttributableValidator getValidator()
 * @method \Amethyst\Authorizers\AttributableAuthorizer getAuthorizer()
 */
class AttributableManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.attribute.data.attributable';
}
