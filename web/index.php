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

$router->any('properties/create', ['wolfram\Controllers\PropertiesController','actionCreate']);
$router->any('properties/update/{id}', ['wolfram\Controllers\PropertiesController','actionUpdate']);
$router->any('properties/delete/{id}', ['wolfram\Controllers\PropertiesController','actionDelete']);

$dispatcher = new Dispatcher($router->getData());
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
