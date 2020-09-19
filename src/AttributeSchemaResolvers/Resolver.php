<?php

namespace Amethyst\AttributeSchemaResolvers;

use Amethyst\Models\AttributeSchema;
use Railken\Lem\Attributes\BaseAttribute;
use Symfony\Component\Yaml\Yaml;
use Railken\Lem\Contracts\ManagerContract;

/**
 * Handle all information conversion from AttributeSchema to BaseAttribute
 */
abstract class Resolver
{
    /**
     * Instance of model AttributeSchema, used to retrieve all information
     * to create an instance of \Railken\Lem\Attributes\BaseAttribute
     *
     * @var AttributeSchema 
     */
    protected $attributeSchema;

    /**
     * Create a new instance
     *
     * @param AttributeSchema $attributeSchema
     */
    public function __construct(AttributeSchema $attributeSchema)
    {
        $this->attributeSchema = $attributeSchema;
    }

    /**
     * Return \Railken\Lem\Attributes\TextAttribute class
     *
     * @return string
     */
    abstract public function getSchemaClass(): string;

    /**
     * Create a new instance of BaseAttribute
     *
     * @return BaseAttribute
     */
    public function getInstanceAttribute(): BaseAttribute
    {
        $class = $this->getSchemaClass();
        return $class::make($this->attributeSchema->name);
    }

    /**
     * Load some information into $attribute
     *
     * @param BaseAttribute $attribute
     *
     * @return BaseAttribute
     */
    public function loadInstanceAttribute(BaseAttribute $attribute): BaseAttribute
    {
        $this->loadRequired($attribute);
        $this->loadRegex($attribute);
        $this->loadOptions($attribute, $this->getOptions());

        return $attribute;
    }

    /**
     * Create a new attribute, boot it and add to the manager
     *
     * @param ManagerContract $manager
     */
    public function boot(ManagerContract $manager)
    {
        $attribute = $this->getInstanceAttribute();
        $this->loadInstanceAttribute($attribute);
        $attribute->setManager($manager);
        $manager->addAttribute($attribute);
    }

    /**
     * Retrieve custom options from $attributeSchema
     *
     * @return \stdClass
     */
    protected function getOptions()
    {
        return (object) Yaml::parse((string) $this->attributeSchema->options);
    }

    /**
     * Load the required flag into $attribute
     *
     * @param BaseAttribute $attribute
     */
    protected function loadRequired(BaseAttribute $attribute)
    {
        $attribute->setRequired($this->attributeSchema->required);
    }

    /**
     * Load regex configuration into $attribute
     *
     * @param BaseAttribute $attribute
     */
    protected function loadRegex(BaseAttribute $attribute)
    {
        if (!empty($this->attributeSchema->regex)) {
            $attribute->setValidator(function ($entity, $value) {
                return preg_match($this->attributeSchema->regex, $value);
            });
        }
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
        // ..
    }

    /**
     * Attach custom options to the $column 
     * when migrating the database
     *
     * @param $column
     */
    public function callDatabaseOptions($column)
    {
        // ..
    }

    /**
     * Retrieve the basic arguments when creating the $colum instance 
     * for the migration of the database
     *
     * @return array
     */
    public function getDatabaseArguments(): array
    {
        return [$this->attributeSchema->name];
    }
}
