<?php

return [
    'enabled'    => true,
    'controller' => Railken\Amethyst\Http\Controllers\Admin\AttributesController::class,
    'router'     => [
        'as'     => 'attribute.',
        'prefix' => '/attributes',
    ],
];
