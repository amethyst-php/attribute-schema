<?php

return [
    'enabled'    => true,
    'controller' => Railken\Amethyst\Http\Controllers\Admin\AttributeValuesController::class,
    'router'     => [
        'as'     => 'attribute-value.',
        'prefix' => '/attribute-values',
    ],
];
