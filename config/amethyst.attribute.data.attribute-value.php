<?php

return [
    'table'      => 'amethyst_attribute_values',
    'comment'    => 'AttributeValue',
    'model'      => Amethyst\Models\AttributeValue::class,
    'schema'     => Amethyst\Schemas\AttributeValueSchema::class,
    'repository' => Amethyst\Repositories\AttributeValueRepository::class,
    'serializer' => Amethyst\Serializers\AttributeValueSerializer::class,
    'validator'  => Amethyst\Validators\AttributeValueValidator::class,
    'authorizer' => Amethyst\Authorizers\AttributeValueAuthorizer::class,
    'faker'      => Amethyst\Fakers\AttributeValueFaker::class,
    'manager'    => Amethyst\Managers\AttributeValueManager::class,
];
