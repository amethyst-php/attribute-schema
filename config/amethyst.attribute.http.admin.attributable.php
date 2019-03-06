<?php

return [
    'enabled'    => true,
    'controller' => Railken\Amethyst\Http\Controllers\Admin\AttributablesController::class,
    'router'     => [
        'as'     => 'attributable.',
        'prefix' => '/attributables',
    ],
];
