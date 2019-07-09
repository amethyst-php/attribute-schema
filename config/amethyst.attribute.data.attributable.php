<?php

return [
    'table'      => 'amethyst_attributables',
    'comment'    => 'Attributable',
    'model'      => Amethyst\Models\Attributable::class,
    'schema'     => Amethyst\Schemas\AttributableSchema::class,
    'repository' => Amethyst\Repositories\AttributableRepository::class,
    'serializer' => Amethyst\Serializers\AttributableSerializer::class,
    'validator'  => Amethyst\Validators\AttributableValidator::class,
    'authorizer' => Amethyst\Authorizers\AttributableAuthorizer::class,
    'faker'      => Amethyst\Fakers\AttributableFaker::class,
    'manager'    => Amethyst\Managers\AttributableManager::class,
    'attributes' => [
        'attributable' => [
            'options' => [],
        ],
    ],
];
