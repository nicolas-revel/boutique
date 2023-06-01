<?php

require('../vendor/autoload.php');

use App\Router\Router;

$router = new Router($_GET['url']);

$_ENV['BASE_URI'] = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/' . explode(
        '/',
        $_SERVER['REQUEST_URI']
    )[1] . '/';

$router->add('/product/:id-:slug', 'Product#show', 'product_show')
    ->withParam(
        ':id',
        '[0-9]+'
    )
    ->withParam(
        ':slug',
        '[a-z0-9\-]+'
    );
$router->add('/', 'Home#index', 'home');
$router->add('/admin', 'Admin#index', 'admin');
$router->add('/admin/:table/list', 'Admin#list', 'admin_table_list')
    ->withParam(
        ':table',
        '[a-z]+'
    );
$router->add('/admin/:table/view/:id', 'Admin#view', 'admin_table_view_id')
    ->withParam(
        ':table',
        '[a-z]+'
    )
    ->withParam(
        ':id',
        '[0-9]+'
    );
$router->add('/admin/:table/edit/:id', 'Admin#edit', 'admin_table_edit_id')
    ->withParam(
        ':table',
        '[a-z]+'
    )
    ->withParam(
        ':id',
        '[0-9]+'
    );
$router->add('/admin/:table/update/:id', 'Admin#index', 'admin_table_update_id')
    ->withParam(
        ':table',
        '[a-z]+'
    )
    ->withParam(
        ':id',
        '[0-9]+'
    );


try {
    $router->run();
} catch (\App\Router\RouterException $e) {
    header('HTTP/1.1 404 Not Found');
}