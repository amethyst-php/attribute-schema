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
        return [
            Attributes\IdAttribute::make(),
            Attributes\BelongsToAttribute::make('attribute_id')
                ->setRelationName('attribute')
                ->setRelationManager(AttributeManager::class)
                ->setRequired(true),
            AmethystAttributes\CustomAttribute::make('value'),
            Attributes\EnumAttribute::make('attributable_type', app('amethyst')->getMorphListable('attribute-value', 'attributable'))
                ->setRequired(true),
            Attributes\MorphToAttribute::make('attributable_id')
                ->setRelationKey('attributable_type')
                ->setRelationName('attributable')
                ->setRelations(app('amethyst')->getMorphRelationable('attribute-value', 'attributable'))
                ->setRequired(true),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
