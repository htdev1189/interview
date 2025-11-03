<?php

namespace App\Core;

use App\Util\HKT;

class Request
{
    /**
     * $get: lưu dữ liệu từ $_GET
     * $post: lưu dữ liệu từ $_POST
     * $server: lưu dữ liệu từ $_SERVER (thường chứa thông tin về server và request, ví dụ: method, URI,...).
     */
    private array $get;
    private array $post;
    private array $server;

    // constructor
    public function __construct(array $get, array $post, array $server)
    {
        $this->get = $get;
        $this->post = $post;
        $this->server = $server;
    }

    /**
     * factory method
     * giúp tạo object Request trực tiếp từ PHP superglobals.
     * Trả về một instance của lớp Request
     * 
     * $request = Request::createFromGlobals();
     */
    public static function createFromGlobals()
    {
        return new self($_GET ?? [], $_POST ?? [], $_SERVER ?? []);
    }


    /**
     * Lấy phương thức HTTP của request (GET, POST, PUT, DELETE, v.v.).
     * 
     * Nếu không tồn tại trong biến server, mặc định trả về 'GET'.
     * Kết quả luôn được chuyển thành chữ in hoa bằng strtoupper().
     * 
     * @return string
     */

    public function getMethod(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    /**
     * $url = 'http://username:password@hostname:9090/path?arg=value#anchor';
     * $components = parse_url($url);
     * Array
        (
            [scheme] => http
            [host] => hostname
            [port] => 9090
            [user] => username
            [pass] => password
            [path] => /path
            [query] => arg=value
            [fragment] => anchor
        )
     */

    /**
     * The rtrim() function returns the modified string with the specified characters removed from the right end.
     * $text = "  Hello World!   ";
     * $trimmed_text = rtrim($text);
     * echo $trimmed_text; // Output: "  Hello World!"
     */

    /**
     * Lấy phần đường dẫn (path) từ URL của request.
     * 
     * Ví dụ: Với URL `/users/list?page=2`, phương thức sẽ trả về `/users/list`.
     * 
     * Nếu không có `REQUEST_URI`, mặc định trả về '/'.
     * 
     * $a ?: $b  => Nếu $a có giá trị truthy (không phải false, 0, '', null, [], v.v.) → trả về $a còn không trả về $b
     * $a ?? $b => Nếu $a tồn tại và không phải null → trả về $a, còn không trả về $b
     * 
     * @return string Đường dẫn URL của request, không có query string
     */
    public function getPath(): string
    {

        $uri = $this->server['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';

        // Nếu project nằm trong thư mục con /interview
        $scriptName = dirname($this->server['SCRIPT_NAME']); // -> /interview
        if (strpos($path, $scriptName) === 0) {
            $path = substr($path, strlen($scriptName));
        }

        return rtrim($path, '/') ?: '/';


        // $uri = $this->server['REQUEST_URI'] ?? '/';
        // return rtrim(parse_url($uri, PHP_URL_PATH) ?: '/', '/') ?: '/';
    }

    /**
     * Tìm $key trong POST trước, nếu không có thì tìm trong GET.
     * Nếu cả 2 không có → trả về $default.
     */

    public function input(string $key, $default = null)
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    /**
     * array_merge
     * 
     * Gộp hai mảng lại với nhau bằng array_merge().
     * 
     * Nếu là mảng số (indexed array), các phần tử sẽ được nối tiếp.
     * Nếu là mảng kết hợp (associative array), các key trùng sẽ bị ghi đè bởi mảng sau.
     * 
     * @see https://www.php.net/manual/en/function.array-merge.php
     * 
     * Examples:
     * ```php
     * $array1 = [1, 2, 3];
     * $array2 = [4, 5, 6];
     * $result = array_merge($array1, $array2);
     * print_r($result);
     * // Output: Array ( [0] => 1 [1] => 2 [2] => 3 [3] => 4 [4] => 5 [5] => 6 )
 
     * $array1 = ['name' => 'John', 'age' => 25];
     * $array2 = ['age' => 30, 'city' => 'New York'];
     * $result = array_merge($array1, $array2);
     * print_r($result);
     * // Output: Array ( [name] => John [age] => 30 [city] => New York )
     * ```
     */

    /**
     * Trả về một mảng kết hợp tất cả dữ liệu GET + POST.
     * Lưu ý: nếu cùng key ở cả 2, POST sẽ ghi đè GET.
     */
    public function all(): array
    {
        return array_merge($this->get, $this->post);
    }




    // validate
    public function validate(array $rules)
    {
        $validator = new \App\Core\Validator($this->all(), $rules);
        // HKT::dd($validator);

        if ($validator->fails()) {
            # code...
            $_SESSION['errors'] = $validator->errors();
            header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '/'));
            exit;
        }
        return $this->all();
    }
}
