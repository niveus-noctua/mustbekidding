<?php

return [
    'router' => [
        'defaults' => [
            'module'     => 'application',
            'controller' => 'index',
            'action'     => 'index'
        ]
    ],
    'events' => [
        'route' => 'events\RouteEvent'
    ]
];
