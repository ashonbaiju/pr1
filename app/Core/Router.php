<?php
// app/Core/Router.php

class Router {
    private $routes = [
        'GET' => [],
        'POST' => []
    ];

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    public function dispatch($uri, $method) {
        // Strip query string
        $uri = parse_url($uri, PHP_URL_PATH);
        
        $basepath = BASE_URL;
        if ($basepath !== '' && strpos($uri, $basepath) === 0) {
            $uri = substr($uri, strlen($basepath));
        }
        if ($uri == '') $uri = '/';

        if (array_key_exists($uri, $this->routes[$method])) {
            $callback = $this->routes[$method][$uri];
            list($controllerName, $methodName) = explode('@', $callback);

            require_once "../app/Controllers/{$controllerName}.php";
            $controller = new $controllerName();
            $controller->$methodName();
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}
