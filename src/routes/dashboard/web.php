<?php declare(strict_types=1);

/** @var \Illuminate\Routing\Router $router */

$router->get('/', 'DashboardController@index')->name('index');

$router->post('parse', 'DashboardController@parseCharacters')->name('parse');
