<?php

namespace Amethyst\AttributeSchemaResolvers;

use Amethyst\Exceptions\AttributeSchemaPayloadInvalidException;
use Railken\Lem\Attributes\BaseAttribute;

class NumberResolver extends Resolver
{
    /**
     * Return \Railken\Lem\Attributes\BaseAttribute class
     *
     * @return string
     */
    public function getSchemaClass(): string
    {
        return \Railken\Lem\Attributes\NumberAttribute::class;
    }

    /**
     * Load additional options for the attribute
     *
     * @param BaseAttribute $attribute
     * @param \stdClass $options
     *
     * @return void
     */
    public function loadOptions(BaseAttribute $attribute, \stdClass $options)
    {
        if (!empty($options->precision)) {
            $attribute->setPrecision($options->precision);
        }

        if (!empty($options->scale)) {
            $attribute->setScale($options->scale);
        }
    }

    public function getDatabaseArguments(): array
    {
        $arguments = parent::getDatabaseArguments();

        $options = $this->getOptions();

        if (!empty($options->precision)) {
            $arguments[] = $options->precision;
        }

        if (!empty($options->scale)) {
            $arguments[] = $options->scale;
        }

        return $arguments;
    }

    public function validate()
    {

    }
}
