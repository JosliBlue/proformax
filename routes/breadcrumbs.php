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
Breadcrumbs::for('papers', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Proformas', route('papers'));
});
Breadcrumbs::for('products', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Productos', route('products'));
});
Breadcrumbs::for('sellers', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Vendedores', route('sellers'));
});
Breadcrumbs::for('settings', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Preferencias', route('settings'));
});
