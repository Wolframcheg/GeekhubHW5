<?php
ini_set('display_errors', 1);
require __DIR__ . '/../config/autoload.php';

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

$router = new RouteCollector();

$router->any('/', ['wolfram\Controllers\IndexController','actionIndex']);
$router->any('/create-tables', ['wolfram\Controllers\CreateTablesController','actionIndex']);

$dispatcher = new Dispatcher($router->getData());
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
