<?php

namespace Railken\Amethyst\Schemas;

use Illuminate\Support\Facades\Config;
use Railken\Amethyst\Attributes as AmethystAttributes;
use Railken\Amethyst\Managers\AttributeManager;
use Railken\Lem\Attributes;
use Railken\Lem\Schema;

class AttributeValueSchema extends Schema
{
    /**
     * Get all the attributes.
     *
     * @var array
     */
    public function getAttributes()
    {
        $attributableConfig = Config::get('amethyst.attribute.data.attributable.attributes.attributable.options');

        return [
            Attributes\IdAttribute::make(),
            Attributes\BelongsToAttribute::make('attribute_id')
                ->setRelationName('attribute')
                ->setRelationManager(AttributeManager::class)
                ->setRequired(true),
            AmethystAttributes\CustomAttribute::make('value'),
            Attributes\EnumAttribute::make('attributable_type', array_keys($attributableConfig))
                ->setRequired(true),
            Attributes\MorphToAttribute::make('attributable_id')
                ->setRelationKey('attributable_type')
                ->setRelationName('attributable')
                ->setRelations($attributableConfig)
                ->setRequired(true),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
