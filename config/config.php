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
    ],
    'site_preferences' => [
        'mode' => 'developer',
        'display_errors' => false
    ]
];
