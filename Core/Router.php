<?php

namespace App\Core;

use App\Util\HKT;

class Router
{
    public static array $routes = [];

    /**
     * Chuẩn hóa đường dẫn bằng cách loại bỏ dấu gạch chéo ở cuối.
     * `normalizePath('/users/')` → `/users`
     * `normalizePath('')` → `/`
     * `normalizePath('/')` → `/`
     */
    public static function normalizePath(string $p): string
    {
        return rtrim($p, '/') ?: '/';
    }


    /**
     * Đăng ký một router GET vào hệ thống router
     * Example
     * ```php
     * $router->get('/student', 'StudentController@index');
     * $router->get('/teacher', 'TeacherController@index');
     * $router = [
     *      'GET' => [
     *              '/users' => 'StudentController@index',
     *              '/teacher' => 'TeacherController@index',
     *              ]
     * ]
     * ```
     */
    public static function get(string $path, string $action)
    {
        self::$routes['GET'][self::normalizePath($path)] = $action;
    }

    /**
     * Đăng ký một route POST vào hệ thống định tuyến.
     *
     * @param string $path Đường dẫn URL cần đăng ký
     * @param string $action Hàm hoặc controller xử lý khi route được gọi
     */
    public static function post(string $path, string $action)
    {
        self::$routes['POST'][self::normalizePath($path)] = $action;
    }


    /**
     * Đăng ký một route PUT vào hệ thống định tuyến.
     *
     * @param string $path Đường dẫn URL cần đăng ký
     * @param string $action Hàm hoặc controller xử lý khi route được gọi
     */
    public function put(string $path, string $action)
    {
        $this->routes['PUT'][$this->normalizePath($path)] = $action;
    }


    /**
     * Đăng ký một route DELETE vào hệ thống định tuyến.
     *
     * @param string $path Đường dẫn URL cần đăng ký
     * @param string $action Hàm hoặc controller xử lý khi route được gọi
     */
    public function delete(string $path, string $action)
    {
        $this->routes['DELETE'][$this->normalizePath($path)] = $action;
    }



    /**
     * Xử lý request HTTP và điều hướng đến controller/action tương ứng.
     * 
     * - Lấy phương thức HTTP (GET, POST, PUT, DELETE...) và đường dẫn từ request
     * - Tìm action tương ứng trong danh sách route đã đăng ký
     * - Nếu không tìm thấy → trả về 404
     * - Nếu controller không tồn tại → trả về 500
     * - Nếu hợp lệ → gọi phương thức xử lý trong controller và truyền đối tượng Request
     */
    public static function dispatch1(Request $request)
    {
        // get current method
        $method = $request->getMethod();
        // get path
        $path = self::normalizePath($request->getPath());
        // action
        $action = self::$routes[$method][$path] ?? null;

        if (!$action) {
            http_response_code(404);
            echo '404 Not Found';
            return;
        }
        /**
         * $action : TeacherController@index
         * $controllerName : TeacherController
         * $methodName : index
         */

        [$controllerName, $methodName] = explode('@', $action);

        $controllerClass = 'App\\Controller\\' . $controllerName;

        if (!class_exists($controllerClass)) {
            http_response_code(500);
            echo 'Controller not found: ' . $controllerClass;
            return;
        }

        $controller = new $controllerClass();

        /**
         * call_user_func
         * 
         * ```php
         * // Calling a global function
         *  function greet($name) {
         *       echo "Hello, $name!\n";
         *   }
         *   call_user_func('greet', 'Alice'); //Hello, Alice! 

         * // Calling an object method
         * class MyClass {
         *     public function sayHello($name) {
         *           echo "MyClass says hello to $name!\n";
         *     }
         * 
         *     public static function staticHello($name) {
         *           echo "MyClass static method says hello to $name!\n";
         *     }
         * }
         * 
         * $obj = new MyClass();
         * call_user_func(array($obj, 'sayHello'), 'Bob'); // MyClass says hello to Bob <áp dụng cho project này>
         * 
         * // Calling a static class method
         * call_user_func(array('MyClass', 'staticHello'), 'Charlie'); // MyClass static method says hello to Charlie
         * call_user_func('MyClass::staticHello', 'David'); // MyClass static method says hello to David
         * 
         */

        try {
            if (!method_exists($controller, $methodName)) {
                throw new \Exception("Method $methodName not found in $controllerClass");
            }
            echo call_user_func([$controller, $methodName], $request);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo "Error: " . $e->getMessage();
        }
    }

    public static function dispatch(Request $request)
    {
        $method = $request->getMethod();
        var_dump($method);
        $path   = self::normalizePath($request->getPath());
        var_dump($path);
        // Lấy tất cả routes đã đăng ký cho method hiện tại
        $routes = self::$routes[$method] ?? [];

        HKT::dd($routes);

        foreach ($routes as $route => $action) {
            // Biến {id} thành regex (?P<id>[^/]+)
            $pattern = "@^" . preg_replace('@\{([\w]+)\}@', '(?P<$1>[^/]+)', $route) . "$@";

            if (preg_match($pattern, $path, $matches)) {
                // Lấy params (lọc ra chỉ giữ các key tên)
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Tách controller & method
                [$controllerName, $methodName] = explode('@', $action);
                $controllerClass = 'App\\Controller\\' . $controllerName;

                try {
                    if (!class_exists($controllerClass)) {
                        throw new \Exception("Controller not found: $controllerClass");
                    }

                    $controller = new $controllerClass();

                    if (!method_exists($controller, $methodName)) {
                        throw new \Exception("Method $methodName not found in $controllerClass");
                    }

                    // Gọi action, truyền cả Request và params
                    return call_user_func([$controller, $methodName], $request, $params);
                } catch (\Throwable $e) {
                    http_response_code(500);
                    echo "Error: " . $e->getMessage();
                    return;
                }
            }
        }

        // Nếu không có route khớp
        http_response_code(404);
        echo "404 Not Found";
    }
}
