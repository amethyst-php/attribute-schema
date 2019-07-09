<?php

return [
    'table'      => 'amethyst_attributes',
    'comment'    => 'Attribute',
    'model'      => Amethyst\Models\Attribute::class,
    'schema'     => Amethyst\Schemas\AttributeSchema::class,
    'repository' => Amethyst\Repositories\AttributeRepository::class,
    'serializer' => Amethyst\Serializers\AttributeSerializer::class,
    'validator'  => Amethyst\Validators\AttributeValidator::class,
    'authorizer' => Amethyst\Authorizers\AttributeAuthorizer::class,
    'faker'      => Amethyst\Fakers\AttributeFaker::class,
    'manager'    => Amethyst\Managers\AttributeManager::class,
];
