<?php

namespace App\Core;

use ReflectionMethod;
use App\Core\Request;
use App\Core\Response;
use Exception;

class Router
{
    private $routes = [];

    /**
     * Add a route with an optional middleware.
     *
     * @param string $method The HTTP method (GET, POST, etc.).
     * @param string $uri The route URI.
     * @param string $action The controller and method (e.g., "HomeController@index").
     * @param array $middleware An array of middleware classes.
     */
    public function add($method, $uri, $action, $middleware = [])
    {
        // Convert route parameters (e.g., /user/{id} -> /user/([^/]+))
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $uri);

        // Store the route
        $this->routes[$method][$pattern] = [
            'action' => $action,
            'middleware' => $middleware,
            'params' => []
        ];
    }

    /**
     * Dispatch the request to the appropriate controller method.
     *
     * @param string $method The HTTP method.
     * @param string $uri The request URI.
     */
    public function dispatch($method, $uri)
    {
        // Check if method exists in routes before looping
        if (!isset($this->routes[$method]) || !is_array($this->routes[$method])) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        foreach ($this->routes[$method] as $pattern => $route) {
            if (preg_match("#^$pattern$#", $uri, $matches)) {
                array_shift($matches);
                $route['params'] = $matches;
                $this->applyMiddleware($route['middleware']);
                return $this->executeAction($route);
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    /**
     * Apply middleware to the route.
     *
     * @param array $middleware An array of middleware classes.
     */
    private function applyMiddleware(array $middleware)
    {
        foreach ($middleware as $key => $allowedRoles) {
            $middlewareClass = is_numeric($key) ? "App\\Middleware\\$allowedRoles" : "App\\Middleware\\$key";

            if (!class_exists($middlewareClass)) {
                throw new Exception("Middleware {$middlewareClass} not found.");
            }

            // If roles are provided, pass them to the middleware
            is_array($allowedRoles) ? $middlewareClass::handle($allowedRoles) : $middlewareClass::handle();
        }
    }

    /**
     * Execute the controller action.
     *
     * @param array $route The route configuration.
     */
    private function executeAction(array $route)
    {
        // Instantiate Request and Response
        $request = new Request();
        $response = new Response();

        // Extract controller and method
        list($controller, $method) = explode('@', $route['action']);
        $controller = "App\\Controllers\\$controller"; // Ensure proper namespace

        if (!class_exists($controller)) {
            throw new Exception("Controller {$controller} not found.");
        }

        $controllerInstance = new $controller();

        if (!method_exists($controllerInstance, $method)) {
            throw new Exception("Method {$method} not found in {$controller}.");
        }

        // Use Reflection to determine parameter expectations
        $reflection = new ReflectionMethod($controllerInstance, $method);
        $params = $reflection->getParameters();
        $args = [];

        if (count($params) === count($route['params'])) {
            $args = $route['params'];
        } elseif (count($params) > 0) {
            $args = [$request, $response, ...$route['params']];
        }

        return $controllerInstance->$method(...$args);
    }
}
