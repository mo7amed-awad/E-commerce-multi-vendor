<?php
return[
[
    'icon'=>'nav-icon fas fa-tachometer-alt',
    'route'=>'dashboard.',
    'title'=>'Dashbaord',
    'active' => 'dashboard',

],
[
    'icon'=>'fas fa-tags nav-icon',
    'route'=>'dashboard.categories.index',
    'title'=>'Categories',
    'badge'=>'New',
    'active' => 'dashboard.categories.*',
    'ability'=>'categories.view',

],
[
    'icon'=>'fas fa-box nav-icon',
    'route'=>'dashboard.products.index',
    'title'=>'Products',
    'active' => 'dashboard.products.*',
    'ability'=>'product.view',


],
[
    'icon'=>'fas fa-receipt nav-icon',
    'route'=>'dashboard.categories.index',
    'title'=>'Orders',
    'active' => 'dashboard.orders.*',

],
[
    'icon'=>'fas fa-shield nav-icon',
    'route'=>'dashboard.roles.index',
    'title'=>'Roles',
    'active' => 'dashboard.orders.*',

],

];
