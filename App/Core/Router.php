<?php

namespace App\Core;

use ReflectionMethod;
use App\Core\Request;
use App\Core\Response;
use Exception;

class Router
{
    private $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => []
    ];

    /**
     * Add a route with an optional middleware.
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
     */
    public function dispatch($method, $uri)
    {
        // Convert method override if request is sent via POST
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }

        // Remove query string
        $uri = parse_url($uri, PHP_URL_PATH);

        // Check if method exists in routes before looping
        if (!isset($this->routes[$method])) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        foreach ($this->routes[$method] as $pattern => $route) {
            if (preg_match("#^$pattern$#", $uri, $matches)) {
                array_shift($matches);
                $route['params'] = array_map(fn($param) => is_numeric($param) ? (int)$param : $param, $matches);
                $this->applyMiddleware($route['middleware']);
                return $this->executeAction($route);
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    /**
     * Apply middleware to the route.
     */
    private function applyMiddleware(array $middleware)
    {
        foreach ($middleware as $key => $allowedRoles) {
            $middlewareClass = is_numeric($key) ? "App\\Middleware\\$allowedRoles" : "App\\Middleware\\$key";

            if (!class_exists($middlewareClass)) {
                throw new Exception("Middleware {$middlewareClass} not found.");
            }

            is_array($allowedRoles) ? $middlewareClass::handle($allowedRoles) : $middlewareClass::handle();
        }
    }

    /**
     * Execute the controller action.
     */
    private function executeAction(array $route)
    {
        $request = new Request();
        $response = new Response();

        list($controller, $method) = explode('@', $route['action']);
        $controller = "App\\Controllers\\$controller";

        if (!class_exists($controller)) {
            throw new Exception("Controller {$controller} not found.");
        }

        $controllerInstance = new $controller();

        if (!method_exists($controllerInstance, $method)) {
            throw new Exception("Method {$method} not found in {$controller}.");
        }

        $reflection = new ReflectionMethod($controllerInstance, $method);
        $params = $reflection->getParameters();
        $args = [];

        // Ensure correct parameter passing
        if (count($params) > 0) {
            if ($params[0]->getType() && $params[0]->getType()->getName() === Request::class) {
                $args[] = $request;
            }
            if (isset($params[1]) && $params[1]->getType() && $params[1]->getType()->getName() === Response::class) {
                $args[] = $response;
            }
        }

        $args = array_merge($args, $route['params']);

        return $controllerInstance->$method(...$args);
    }
}
