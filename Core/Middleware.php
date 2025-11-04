<?php

namespace App\Core;

class Middleware
{
    public static function handle(array $middlewares, callable $next)
    {
        foreach ($middlewares as $middleware) {
            (new $middleware())->handle();
        }
        return $next();
    }
}
