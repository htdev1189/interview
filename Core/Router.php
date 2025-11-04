<?php

namespace App\Core;

use App\Util\HKT;

class Router
{
    public static array $routes = [];
    public static array $namedRoutes = [];

    public static array $middlewares = [];
    public static array $groupMiddlewares = [];
    public static array $currentGroupMiddleware = [];


    /** Chuẩn hóa đường dẫn */
    public static function normalizePath(string $p): string
    {
        return rtrim($p, '/') ?: '/';
    }

    /** Đăng ký route GET */
    public static function get(string $path, string $action): RouteDefinition
    {
        $normalized = self::normalizePath($path);
        self::$routes['GET'][$normalized] = $action;

        // Nếu đang trong group middleware thì gán luôn
        if (!empty(self::$currentGroupMiddleware)) {
            self::$middlewares['GET'][$normalized] = self::$currentGroupMiddleware;
        }


        return new RouteDefinition('GET', $normalized, $action);
    }

    /** Đăng ký route POST */
    public static function post(string $path, string $action): RouteDefinition
    {
        $normalized = self::normalizePath($path);
        self::$routes['POST'][$normalized] = $action;

        // Nếu đang trong group middleware thì gán luôn
        if (!empty(self::$currentGroupMiddleware)) {
            self::$middlewares['POST'][$normalized] = self::$currentGroupMiddleware;
        }

        return new RouteDefinition('POST', $normalized, $action);
    }

    /** Đăng ký route PUT */
    public static function put(string $path, string $action): RouteDefinition
    {
        $normalized = self::normalizePath($path);
        self::$routes['PUT'][$normalized] = $action;

        // Nếu đang trong group middleware thì gán luôn
        if (!empty(self::$currentGroupMiddleware)) {
            self::$middlewares['PUST'][$normalized] = self::$currentGroupMiddleware;
        }

        return new RouteDefinition('PUT', $normalized, $action);
    }

    /** Đăng ký route DELETE */
    public static function delete(string $path, string $action): RouteDefinition
    {
        $normalized = self::normalizePath($path);
        self::$routes['DELETE'][$normalized] = $action;

        // Nếu đang trong group middleware thì gán luôn
        if (!empty(self::$currentGroupMiddleware)) {
            self::$middlewares['DELETE'][$normalized] = self::$currentGroupMiddleware;
        }


        return new RouteDefinition('DELETE', $normalized, $action);
    }

    /** Dispatch - xử lý request */
    public static function dispatch(Request $request)
    {
        $method = $request->getMethod();
        $path   = self::normalizePath($request->getPath());
        $routes = self::$routes[$method] ?? [];

        foreach ($routes as $route => $action) {
            $pattern = "@^" . preg_replace('@\{([\w]+)\}@', '(?P<$1>[^/]+)', $route) . "$@";

            if (preg_match($pattern, $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                [$controllerName, $methodName] = explode('@', $action);
                $controllerClass = 'App\\Controller\\' . $controllerName;

                try {
                    if (!class_exists($controllerClass)) {
                        throw new \Exception("Controller not found: $controllerClass");
                    }

                    // ✅ chạy middleware trước khi gọi controller
                    $middlewares = self::$middlewares[$method][$route] ?? [];
                    foreach ($middlewares as $mw) {
                        $class = "App\\Middleware\\{$mw}";
                        if (class_exists($class)) {
                            (new $class)->handle($request);
                        }
                    }


                    $controller = new $controllerClass();

                    if (!method_exists($controller, $methodName)) {
                        throw new \Exception("Method $methodName not found in $controllerClass");
                    }

                    $reflection = new \ReflectionMethod($controller, $methodName);
                    $args = [];

                    foreach ($reflection->getParameters() as $param) {
                        if (
                            $param->getType()
                            && !$param->getType()->isBuiltin()
                            && $param->getType()->getName() === Request::class
                        ) {
                            $args[] = $request;
                        } elseif (isset($params[$param->getName()])) {
                            $args[] = $params[$param->getName()];
                        } else {
                            $args[] = null;
                        }
                    }

                    return call_user_func_array([$controller, $methodName], $args);
                } catch (\Throwable $e) {
                    http_response_code(500);
                    echo "Error: " . $e->getMessage();
                    return;
                }
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    /** Trả về URL theo route name */
    public static function url(string $name, array $params = []): ?string
    {
        if (!isset(self::$namedRoutes[$name])) {
            return null;
        }

        $path = self::$namedRoutes[$name]['path'];

        foreach ($params as $key => $value) {
            $path = str_replace('{' . $key . '}', $value, $path);
        }

        // Tự động thêm base path (vd: /interview)
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        return $base . $path;
    }

    public static function hasRoute(string $name): bool
    {
        return isset(self::$namedRoutes[$name]);
    }

    public static function redirect(string $name, array $params = []): void
    {
        $url = self::url($name, $params);

        if (!$url) {
            throw new \Exception("Route name '{$name}' not found.");
        }

        header("Location: $url");
        exit;
    }

    public static function group(array $options, callable $callback): void
    {
        $middleware = $options['middleware'] ?? null;

        if ($middleware) {
            $middlewares = is_array($middleware) ? $middleware : [$middleware];
            self::$currentGroupMiddleware = array_merge(self::$currentGroupMiddleware, $middlewares);
        }

        // gọi callback để đăng ký các route bên trong group
        $callback();

        // xóa middleware group sau khi đăng ký xong
        if ($middleware) {
            self::$currentGroupMiddleware = array_slice(
                self::$currentGroupMiddleware,
                0,
                count(self::$currentGroupMiddleware) - count((array)$middleware)
            );
        }
    }
}
