<?php

return [
    // Citadel Developer control "build" or "development"
    // "build" for end user (default)
    // "development" for developer 
    'mode' => 'build',
    'views' => [
        'page' => "citadel-template::core"
    ],
    'template' => [
        'js' => [
            'resources/js/app.js',
            'resources/js/bootstrap.js',
        ]
    ],
    'sidebar' => \Citadel\Handler\SidebarHandler::class,
    'header' => \Citadel\Handler\HeaderHandler::class
];
