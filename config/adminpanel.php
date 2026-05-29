<?php

return [
    'brand' => [
        'label' => env('ADMIN_BRAND_NAME', env('APP_NAME', 'Admin Panel')),
        'logo' => 'adminlte4/assets/img/AdminLTELogo.png',
    ],

    'layout' => [
        'body_class' => 'layout-fixed sidebar-expand-lg bg-body-tertiary',
        'sidebar_theme' => 'dark',
        'footer_text' => 'All rights reserved.',
    ],

    'plugins' => [
        'font_source_sans' => [
            'enabled' => true,
            'css' => 'https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css',
        ],
        'bootstrap_icons' => [
            'enabled' => true,
            'css' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css',
        ],
        'fontawesome' => [
            'enabled' => true,
            'css' => 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css',
        ],
        'bootstrap_bundle' => [
            'enabled' => true,
            'js' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js',
        ],
        'overlayscrollbars' => [
            'enabled' => true,
            'css' => 'https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css',
            'js' => 'https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js',
        ],
    ],

    'menu' => [
        ['type' => 'main', 'route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'icon' => 'fas fa-tachometer-alt', 'label' => 'Dashboard'],
        ['type' => 'catalog', 'route' => 'admin.categories.index', 'pattern' => 'admin.categories.*', 'icon' => 'fas fa-tags', 'label' => 'Categories'],
        ['type' => 'catalog', 'route' => 'admin.avenues.index', 'pattern' => 'admin.avenues.*', 'icon' => 'fas fa-map-marker-alt', 'label' => 'Avenues'],
        ['type' => 'catalog', 'route' => 'admin.events.index', 'pattern' => 'admin.events.*', 'icon' => 'fas fa-calendar-alt', 'label' => 'Events'],
        ['type' => 'catalog', 'route' => 'admin.services.index', 'pattern' => 'admin.services.*', 'icon' => 'fas fa-concierge-bell', 'label' => 'Services'],
        ['type' => 'catalog', 'route' => 'admin.clients.index', 'pattern' => 'admin.clients.*', 'icon' => 'fas fa-handshake', 'label' => 'Clients'],
        ['type' => 'catalog', 'route' => 'admin.bookings.index', 'pattern' => 'admin.bookings.*', 'icon' => 'fas fa-calendar-check', 'label' => 'Bookings'],
        ['type' => 'catalog', 'route' => 'admin.tasks.index', 'pattern' => 'admin.tasks.*', 'icon' => 'fas fa-tasks', 'label' => 'Tasks'],
        ['type' => 'finance', 'route' => 'admin.quotations.index', 'pattern' => 'admin.quotations.*', 'icon' => 'fas fa-file-invoice-dollar', 'label' => 'Quotations'],
        ['type' => 'finance', 'route' => 'admin.payments.index', 'pattern' => 'admin.payments.*', 'icon' => 'fas fa-credit-card', 'label' => 'Payments'],
        ['type' => 'finance', 'route' => 'admin.vendors.index', 'pattern' => 'admin.vendors.*', 'icon' => 'fas fa-store', 'label' => 'Vendors'],
        ['type' => 'access', 'route' => 'admin.users.index', 'pattern' => 'admin.users.*', 'icon' => 'fas fa-users', 'label' => 'Users'],
        ['type' => 'access', 'route' => 'admin.roles.index', 'pattern' => 'admin.roles.*', 'icon' => 'fas fa-user-shield', 'label' => 'Roles'],
        ['type' => 'access', 'route' => 'admin.permissions.index', 'pattern' => 'admin.permissions.*', 'icon' => 'fas fa-key', 'label' => 'Permissions'],
        ['type' => 'system', 'route' => 'admin.settings.edit', 'pattern' => 'admin.settings.*', 'icon' => 'fas fa-cog', 'label' => 'Settings'],
    ],
];
