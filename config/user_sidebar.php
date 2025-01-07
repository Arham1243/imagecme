<?php

return [
    [
        'title' => 'Dashboard',
        'icon' => 'bx bxs-home',
        'route' => 'user.dashboard',
    ],
    [
        'title' => 'Analytics',
        'icon' => 'bx bx-bar-chart-alt',
        'route' => 'user.analytics.cases',
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
        'title' => 'Profile Settings',
        'icon' => 'bx bxs-cog',
        'submenu' => [
            [
                'title' => 'Personal Information',
                'icon' => 'bx bxs-contact',
                'route' => 'user.profile.index',
            ],
            [
                'title' => 'Change Password',
                'icon' => 'bx bx-key',
                'route' => 'user.profile.changePassword',
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
