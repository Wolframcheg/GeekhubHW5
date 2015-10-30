<?php
ini_set('display_errors', 1);
require __DIR__ . '/../config/autoload.php';

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

$router = new RouteCollector();

$router->any('/', ['wolfram\Controllers\IndexController','actionIndex']);
$router->any('create-tables', ['wolfram\Controllers\CreateTablesController','actionIndex']);

$router->any('vendor/create', ['wolfram\Controllers\VendorController','actionCreate']);
$router->any('vendor/update/{id}', ['wolfram\Controllers\VendorController','actionUpdate']);
$router->any('vendor/delete/{id}', ['wolfram\Controllers\VendorController','actionDelete']);
$router->any('vendor/view-transports/{id}', ['wolfram\Controllers\VendorController','actionViewTransports']);

$router->any('properties/create', ['wolfram\Controllers\PropertiesController','actionCreate']);
$router->any('properties/update/{id}', ['wolfram\Controllers\PropertiesController','actionUpdate']);
$router->any('properties/delete/{id}', ['wolfram\Controllers\PropertiesController','actionDelete']);

$router->any('transport/create', ['wolfram\Controllers\TransportController','actionCreate']);
$router->any('transport/update/{id}', ['wolfram\Controllers\TransportController','actionUpdate']);
$router->any('transport/delete/{id}', ['wolfram\Controllers\TransportController','actionDelete']);
$router->any('transport/delete-property/{id_transport}/{id_properties}', ['wolfram\Controllers\TransportController','actionDeleteProperty']);
$router->any('transport/add-property', ['wolfram\Controllers\TransportController','actionAddProperty']);

$dispatcher = new Dispatcher($router->getData());
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
