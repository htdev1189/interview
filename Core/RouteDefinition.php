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
}
