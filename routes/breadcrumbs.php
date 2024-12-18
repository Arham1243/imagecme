<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// --------------- Admin Dashboard---------------
Breadcrumbs::for('admin.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('admin.dashboard'));
});

Breadcrumbs::for('admin.logo.show', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Logo Management', route('admin.logo.show'));
});
Breadcrumbs::for('admin.contact.show', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Contact/Social Info', route('admin.contact.show'));
});
// --------------- Admin Dashboard---------------

// --------------- Usdr Dashboard---------------
Breadcrumbs::for('user.cases.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Cases', route('user.cases.index'));
});
Breadcrumbs::for('user.cases.create', function (BreadcrumbTrail $trail) {
    $trail->parent('user.cases.index');
    $trail->push('Add Case', route('user.cases.create'));
});
Breadcrumbs::for('user.cases.edit', function (BreadcrumbTrail $trail, $item) {
    $trail->parent('user.cases.index');
    $trail->push($item->title ?? 'N/A', route('user.cases.edit', $item->id));
});
// --------------- Usdr Dashboard---------------