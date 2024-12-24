<?php

return [
    [
        'title' => 'Website',
        'icon' => 'bx bx-globe',
        'route' => 'frontend.index',
    ],
    [
        'title' => 'Dashboard',
        'icon' => 'bx bxs-home',
        'route' => 'user.dashboard',
    ],
    [
        'title' => 'Images',
        'icon' => 'bx bx-search-alt',
        'submenu' => [
            [
                'title' => 'Images',
                'icon' => 'bx bx-list-ul',
                'route' => 'user.cases.index',
            ],
            [
                'title' => 'Add Image',
                'icon' => 'bx bx-plus',
                'route' => 'user.cases.create',
            ],
            [
                'title' => 'Recovery',
                'icon' => 'bx bx-refresh',
                'route' => ['user.recovery.index', ['resource' => 'cases']],
            ],
        ],
    ],
    [
        'title' => 'Logout',
        'icon' => 'bx bx-power-off',
        'route' => 'user.logout',
        'confirm' => 'Are you sure you want to log out',
    ],
];
