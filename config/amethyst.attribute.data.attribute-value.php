<?php

return [
    'table'      => 'amethyst_attribute_values',
    'comment'    => 'AttributeValue',
    'model'      => Railken\Amethyst\Models\AttributeValue::class,
    'schema'     => Railken\Amethyst\Schemas\AttributeValueSchema::class,
    'repository' => Railken\Amethyst\Repositories\AttributeValueRepository::class,
    'serializer' => Railken\Amethyst\Serializers\AttributeValueSerializer::class,
    'validator'  => Railken\Amethyst\Validators\AttributeValueValidator::class,
    'authorizer' => Railken\Amethyst\Authorizers\AttributeValueAuthorizer::class,
    'faker'      => Railken\Amethyst\Fakers\AttributeValueFaker::class,
    'manager'    => Railken\Amethyst\Managers\AttributeValueManager::class,
];
