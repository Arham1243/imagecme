<?php

return [
    [
        'title' => 'Dashboard',
        'icon' => 'bx bxs-home',
        'route' => route('admin.dashboard'),
    ],
    [
        'title' => 'Site Setting',
        'icon' => 'bx bxs-cog',
        'submenu' => [
            [
                'title' => 'Logo Managment',
                'icon' => 'bx bxs-image',
                'route' => route('admin.logo.show'),
            ],
            [
                'title' => 'Contact/Social Info',
                'icon' => 'bx bxs-chat',
                'route' => route('admin.contact.show'),
            ],
        ],
    ],
];
