<?php

namespace Amethyst\Models;

use Amethyst\Common\ConfigurableModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Railken\Lem\Contracts\EntityContract;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Collection;

/**
 * @property string $schema
 * @property string $options
 */
class Attribute extends Model implements EntityContract
{
    use ConfigurableModel;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->ini('amethyst.attribute.data.attribute');
        parent::__construct($attributes);
    }

    /**
     * Get attributes
     *
     * @param string $config
     *
     * @return Collection
     */
    public static function internalGetAttributes(string $config): Collection
    {
        $schema = Config::get($config.'.schema');
        $schema = new $schema();

        return collect($schema->getAttributes());
    }
}
