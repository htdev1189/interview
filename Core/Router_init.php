<?php
namespace App\Core;

class RouterInit {
    private array $routes = [];

    public function add(string $method, string $pattern, callable $action): void {
        $this->routes[] = compact('method', 'pattern', 'action');
    }

    public function dispatch(string $uri, string $method): void {
        foreach ($this->routes as $route) {
            if ($method !== $route['method']) continue;

            if (preg_match($route['pattern'], $uri, $matches)) {
                array_shift($matches); // bỏ phần full match
                call_user_func_array($route['action'], $matches);
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found: $uri";
    }
}
