<?php

return [
    [
        'title' => 'Dashboard',
        'icon' => 'bx bxs-home',
        'route' => 'admin.dashboard',
    ],
    [
        'title' => 'Analytics',
        'icon' => 'bx bx-bar-chart-alt',
        'route' => 'admin.analytics.cases',
    ],
    [
        'title' => 'Users',
        'icon' => 'bx bxs-group',
        'route' => 'admin.users.index',
    ],
    [
        'title' => 'Images',
        'icon' => 'bx bx-search-alt',
        'route' => 'admin.cases.index',
    ],
    [
        'title' => 'Image Types',
        'icon' => 'bx bx-image',
        'submenu' => [
            [
                'title' => ' Types',
                'icon' => 'bx bxs-image',
                'route' => 'admin.image-types.index',
            ],
            [
                'title' => 'Add  Type',
                'icon' => 'bx bx-plus',
                'route' => 'admin.image-types.create',
            ],
        ],
    ],
    [
        'title' => 'Site Setting',
        'icon' => 'bx bxs-cog',
        'submenu' => [
            [
                'title' => 'Logo',
                'icon' => 'bx bxs-image',
                'route' => 'admin.logo.show',
            ],
            [
                'title' => 'Contact/Social Info',
                'icon' => 'bx bxs-chat',
                'route' => 'admin.contact.show',
            ],
        ],
    ],
    [
        'title' => 'Logout',
        'icon' => 'bx bx-power-off',
        'route' => 'admin.logout',
        'confirm' => 'Are you sure you want to log out',
    ],
];
