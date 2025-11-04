<?php

namespace App\Core;

class RouteDefinition
{
    public function __construct(
        private string $method,
        private string $path,
        private string $action
    ) {}

    public function name(string $routeName): self
    {
        Router::$namedRoutes[$routeName] = [
            'method' => $this->method,
            'path'   => $this->path,
            'action' => $this->action,
        ];
        return $this;
    }

    /** Gán middleware cho riêng route */
    public function middleware(string|array $middleware): self
    {
        $middlewares = is_array($middleware) ? $middleware : [$middleware];
        Router::$middlewares[$this->method][$this->path] = $middlewares;
        return $this;
    }
}
