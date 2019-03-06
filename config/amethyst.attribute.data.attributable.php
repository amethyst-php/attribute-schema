<?php

return [
    'table'      => 'amethyst_attributables',
    'comment'    => 'Attributable',
    'model'      => Railken\Amethyst\Models\Attributable::class,
    'schema'     => Railken\Amethyst\Schemas\AttributableSchema::class,
    'repository' => Railken\Amethyst\Repositories\AttributableRepository::class,
    'serializer' => Railken\Amethyst\Serializers\AttributableSerializer::class,
    'validator'  => Railken\Amethyst\Validators\AttributableValidator::class,
    'authorizer' => Railken\Amethyst\Authorizers\AttributableAuthorizer::class,
    'faker'      => Railken\Amethyst\Fakers\AttributableFaker::class,
    'manager'    => Railken\Amethyst\Managers\AttributableManager::class,
    'attributes' => [
        'attributable' => [
            'options' => [
                Railken\Amethyst\Models\Foo::class => Railken\Amethyst\Managers\FooManager::class,
            ],
        ],
    ],
];
