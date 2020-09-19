<?php

namespace Amethyst\AttributeSchemaResolvers;

use Amethyst\Models\AttributeSchema;
use Railken\Lem\Attributes\BaseAttribute;
use Symfony\Component\Yaml\Yaml;

abstract class Resolver
{
    protected $attributeSchema;

    public function __construct(AttributeSchema $attributeSchema)
    {
        $this->attributeSchema = $attributeSchema;
    }

    abstract public function getSchemaClass(): string;

    public function getInstanceAttribute(): BaseAttribute
    {
        $class = $this->getSchemaClass();
        return $class::make($this->attributeSchema->name);
    }

    public function loadInstanceAttribute(BaseAttribute $attribute): BaseAttribute
    {
        $this->loadRequired($attribute);
        $this->loadRegex($attribute);
        $this->loadOptions($attribute, $this->getOptions());

        return $attribute;
    }

    public function boot($manager)
    {
        $attribute = $this->getInstanceAttribute();
        $this->loadInstanceAttribute($attribute);
        $attribute->setManager($manager);
        $manager->addAttribute($attribute);
    }

    protected function getOptions()
    {
        return (object) Yaml::parse((string) $this->attributeSchema->options);
    }

    protected function loadRequired(BaseAttribute $attribute)
    {
        $attribute->setRequired($this->attributeSchema->required);
    }

    protected function loadRegex(BaseAttribute $attribute)
    {
        if (!empty($this->attributeSchema->regex)) {
            $attribute->setValidator(function ($entity, $value) {
                return preg_match($this->attributeSchema->regex, $value);
            });
        }
    }

    public function loadOptions(BaseAttribute $attribute, \stdClass $options)
    {

    }

    public function callDatabaseOptions($column)
    {
        // ..
    }

    public function getDatabaseArguments(): array
    {
        return [$this->attributeSchema->name];
    }
}
