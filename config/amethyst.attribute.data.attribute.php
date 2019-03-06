<?php

return [
    'table'      => 'amethyst_attributes',
    'comment'    => 'Attribute',
    'model'      => Railken\Amethyst\Models\Attribute::class,
    'schema'     => Railken\Amethyst\Schemas\AttributeSchema::class,
    'repository' => Railken\Amethyst\Repositories\AttributeRepository::class,
    'serializer' => Railken\Amethyst\Serializers\AttributeSerializer::class,
    'validator'  => Railken\Amethyst\Validators\AttributeValidator::class,
    'authorizer' => Railken\Amethyst\Authorizers\AttributeAuthorizer::class,
    'faker'      => Railken\Amethyst\Fakers\AttributeFaker::class,
    'manager'    => Railken\Amethyst\Managers\AttributeManager::class,
];
