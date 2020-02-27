<?php

namespace Amethyst\Managers;

use Amethyst\Core\ConfigurableManager;
use Railken\Lem\Manager;

/**
 * @method \Amethyst\Models\AttributeSchema                 newEntity()
 * @method \Amethyst\Schemas\AttributeSchemaSchema          getSchema()
 * @method \Amethyst\Repositories\AttributeSchemaRepository getRepository()
 * @method \Amethyst\Serializers\AttributeSchemaSerializer  getSerializer()
 * @method \Amethyst\Validators\AttributeSchemaValidator    getValidator()
 * @method \Amethyst\Authorizers\AttributeSchemaAuthorizer  getAuthorizer()
 */
class AttributeSchemaManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.attribute-schema.data.attribute-schema';
}
