<?php

return [
    'enabled'    => true,
    'controller' => Amethyst\Http\Controllers\Admin\AttributesController::class,
    'router'     => [
        'as'     => 'attribute.',
        'prefix' => '/attributes',
    ],
];
