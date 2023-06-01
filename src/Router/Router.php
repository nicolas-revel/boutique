<?php

namespace App\Router;

class Router
{

    private string $url;

    public function __construct(string $url, private array $routes = [])
    {
        $this->url = trim($url, '/');
    }

    public function add(string $path, callable|string $callable, $name = null, $method = 'GET'): Route
    {
        $route = new Route($path, $callable, $name);
        $this->routes[$method][] = $route;
        return $route;
    }

    public function run()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new RouterException('REQUEST_METHOD does not exist');
        }
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                return $route->call($this);
            }
        }
        throw new RouterException('No matching routes');
    }

    public function generate(string $name, array $params = []): array|string
    {
        /** @var Route[] $routes */
        foreach ($this->routes as $routes) {
            foreach ($routes as $route) {
                if ($route->getName() === $name) {
                    return $route->getUrl($params);
                }
            }
        }
        throw new RouterException('No matching routes');
    }


}