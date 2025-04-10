<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Menú', route('home'));
});

Breadcrumbs::for('profile', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Mi perfil', route('profile'));
});

Breadcrumbs::for('customers', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Clientes', route('customers'));
});
Breadcrumbs::for('customers.create', function (BreadcrumbTrail $trail) {
    $trail->parent('customers');
    $trail->push('Nuevo cliente', route('customers.create'));
});
Breadcrumbs::for('customers.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('customers');
    $trail->push('Editar cliente');
});

Breadcrumbs::for('papers', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Proformas', route('papers'));
});
Breadcrumbs::for('products', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Productos', route('products'));
});
Breadcrumbs::for('products.create', function (BreadcrumbTrail $trail) {
    $trail->parent('products');
    $trail->push('Nuevo cliente', route('products.create'));
});
Breadcrumbs::for('products.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('products');
    $trail->push('Editar cliente');
});

Breadcrumbs::for('sellers', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Vendedores', route('sellers'));
});
Breadcrumbs::for('sellers.create', function (BreadcrumbTrail $trail) {
    $trail->parent('sellers');
    $trail->push('Nuevo vendedor', route('sellers.create'));
});
Breadcrumbs::for('sellers.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('sellers');
    $trail->push('Editar vendedor');
});

Breadcrumbs::for('settings', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Preferencias', route('settings'));
});
