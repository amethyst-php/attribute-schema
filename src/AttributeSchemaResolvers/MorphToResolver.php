<?php

namespace Amethyst\AttributeSchemaResolvers;

use Amethyst\Exceptions\AttributeSchemaPayloadInvalidException;
use Railken\Lem\Attributes\BaseAttribute;

class MorphToResolver extends Resolver
{
    /**
     * Return \Railken\Lem\Attribute\BaseAttribute class.
     *
     * @return string
     */
    public function getSchemaClass(): string
    {
        return \Railken\Lem\Attributes\MorphToAttribute::class;
    }

    /**
     * Load additional options for the attribute.
     *
     * @param BaseAttribute $attribute
     * @param \stdClass     $options
     *
     * @return void
     */
    public function loadOptions(BaseAttribute $attribute, \stdClass $options)
    {
        if (empty($options->relationName) || empty($options->relationKey)) {
            throw new AttributeSchemaPayloadInvalidException($this->attributeSchema);
        }

        $keyAttribute = $attribute->getManager()->getAttributes()->first(function ($attr) use ($options) {
            return $attr->getName() === $options->relationKey;
        });

        if (empty($keyAttribute)) {
            throw new AttributeSchemaPayloadInvalidException($this->attributeSchema, sprintf('The parameter `relationKey:%s` is invalid. Create first an attribute with this name or change the current value.', $options->relationKey));
        }

        $attribute->setRelationName($options->relationName);
        $attribute->setRelationKey($options->relationKey);
        $attribute->setRelations(app('amethyst')->getDataManagers());
    }

    /**
     * Attach custom options to the $column
     * when migrating the database.
     *
     * @param $column
     */
    public function callDatabaseOptions($column)
    {
        $column->unsigned();
    }

    /**
     * Called when an attribute is saving.
     */
    public function saving()
    {
        $this->attributeSchema->require = implode(',', [$this->getOptions()->relationKey]);
    }

    public function validate()
    {
    }
}
