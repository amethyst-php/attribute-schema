<?php

return [
    'enabled'    => true,
    'controller' => Amethyst\Http\Controllers\Admin\AttributeValuesController::class,
    'router'     => [
        'as'     => 'attribute-value.',
        'prefix' => '/attribute-values',
    ],
];
