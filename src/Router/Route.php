<?php

namespace App\Router;

class Route
{

    public function __construct(
        private string $path,
        private $callable,
        private ?string $name = null,
        private array $params = [],
        private array $matches = []
    ) {
        $this->path = trim($path, '/');
    }

    public function match($uri): bool
    {
        $uri = trim($uri, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $uri, $matches)) {
            return false;
        }

        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    public function call(Router $router)
    {
        if (is_string($this->callable)) {
            $params = explode('#', $this->callable);
            if (array_key_exists(':table', $this->params) && $params[0] === 'Admin') {
                $params[0] = ucfirst($this->matches[0]) . $params[0];
            }
            $controller = "App\\Controller\\" . $params[0] . "Controller";
            $controller = new $controller($router);
            return call_user_func_array([$controller, $params[1]], $this->matches);
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    private function paramMatch($match): string
    {
        if (isset($this->params[$match[1]])) {
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    public function withParam($param, $regex): static
    {
        $this->params[$param] = str_replace('(', '(?:', $regex);
        var_dump($this->path);
        return $this;
    }

    public function getUrl($params): array|string
    {
        $path = $this->path;
        foreach ($params as $k => $v) {
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }
}