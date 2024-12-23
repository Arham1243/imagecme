<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// --------------- user Dashboard---------------
Breadcrumbs::for('user.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('user.dashboard'));
});

Breadcrumbs::for('user.logo.show', function (BreadcrumbTrail $trail) {
    $trail->parent('user.dashboard');
    $trail->push('Logo Management', route('user.logo.show'));
});
Breadcrumbs::for('user.contact.show', function (BreadcrumbTrail $trail) {
    $trail->parent('user.dashboard');
    $trail->push('Contact/Social Info', route('user.contact.show'));
});
// --------------- user Dashboard---------------

// --------------- Usdr Dashboard---------------

Breadcrumbs::for('user.recovery.index', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent("user.$resource.index");
    $trail->push('Recovery', route('user.recovery.index', ['resource' => $resource]));
});

Breadcrumbs::for('user.cases.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user.dashboard');
    $trail->push('Cases', route('user.cases.index'));
});
Breadcrumbs::for('user.cases.create', function (BreadcrumbTrail $trail) {
    $trail->parent('user.cases.index');
    $trail->push('Add Case', route('user.cases.create'));
});

Breadcrumbs::for('user.cases.edit', function (BreadcrumbTrail $trail, $item) {
    $trail->parent('user.cases.index');
    $trail->push($item->diagnosis_title ?? 'N/A', route('user.cases.edit', $item->id));
});

Breadcrumbs::for('user.cases.chat', function (BreadcrumbTrail $trail, $item) {
    $trail->parent('user.cases.edit', $item);
    $trail->push('Ask AI', route('user.cases.chat', $item->id));
});
// --------------- Usdr Dashboard---------------
