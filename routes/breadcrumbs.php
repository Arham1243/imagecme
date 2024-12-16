<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Admin Dashboard
Breadcrumbs::for('admin.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('admin.dashboard'));
});

// ---------------Site Settings---------------
Breadcrumbs::for('admin.logo.show', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Logo Management', route('admin.logo.show'));
});
Breadcrumbs::for('admin.contact.show', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Contact/Social Info', route('admin.contact.show'));
});
// ---------------Site Settings---------------

Breadcrumbs::for('admin.sections.edit', function (BreadcrumbTrail $trail, $item) {
    $trail->parent('admin.sections.index');
    $trail->push($item->name ?? 'N/A', route('admin.sections.edit', $item->id));
});
// ---------------Sections---------------