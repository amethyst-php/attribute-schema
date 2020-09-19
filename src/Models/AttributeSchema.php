<?php

namespace Amethyst\Models;

use Amethyst\Core\ConfigurableModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Railken\Lem\Contracts\EntityContract;
use Amethyst\AttributeSchemaResolvers\Resolver;

/**
 * @property string $schema
 * @property string $options
 */
class AttributeSchema extends Model implements EntityContract
{
    use ConfigurableModel;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->ini('amethyst.attribute-schema.data.attribute-schema');
        parent::__construct($attributes);
    }

    /**
     * Get attributes.
     *
     * @param string $config
     *
     * @return Collection
     */
    public static function internalGetAttributeSchemas(string $config): Collection
    {
        $schema = Config::get($config.'.schema');
        $schema = new $schema();

        return collect($schema->getAttributeSchemas());
    }

    public function getResolver(): Resolver
    {
        $resolver = config('amethyst.attribute-schema.resolvers.'.$this->schema);

        if (empty($resolver)) {
            throw new \Exception(sprintf("Cannot retrieve the resolver for attribute-schema. Schema `%s` is invalid", $this->schema));
        }

        return new $resolver($this);
    }
}
