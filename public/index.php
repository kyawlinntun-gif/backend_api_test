<?php
require_once '../vendor/autoload.php';

use App\Core\Router;

session_start();
$router = new Router();
// Include routes from the autoloaded routes.php file
$routes = require '../config/routes.php';
// Register routes with the router
foreach ($routes as $method => $route) {
    foreach ($route as $uri => $action) {
        $router->add($method, $uri, $action['action'], $action['middleware'] ?? []);
    }
}
// Dispatch the request
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
