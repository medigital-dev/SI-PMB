<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// API
$routes->group('/api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    $routes->resource('banner');
    $routes->resource('berkas');
    $routes->resource('dokumen');
    $routes->resource('event');
    $routes->resource('forum');
    $routes->resource('header');
    $routes->resource('heroes');
    $routes->resource('identitas');
    $routes->resource('info');
    $routes->resource('jadwal');
    $routes->resource('jalur');
    $routes->resource('logo');
    $routes->resource('syarat');
    $routes->resource('tautan');
    $routes->resource('widget');
});
