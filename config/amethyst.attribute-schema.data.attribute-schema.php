<?php

return [
    'table'      => 'attribute',
    'comment'    => 'AttributeSchema',
    'model'      => Amethyst\Models\AttributeSchema::class,
    'schema'     => Amethyst\Schemas\AttributeSchemaSchema::class,
    'repository' => Amethyst\Repositories\AttributeSchemaRepository::class,
    'serializer' => Amethyst\Serializers\AttributeSchemaSerializer::class,
    'validator'  => Amethyst\Validators\AttributeSchemaValidator::class,
    'authorizer' => Amethyst\Authorizers\AttributeSchemaAuthorizer::class,
    'faker'      => Amethyst\Fakers\AttributeSchemaFaker::class,
    'manager'    => Amethyst\Managers\AttributeSchemaManager::class,
];
