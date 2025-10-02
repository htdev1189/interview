<?php 
declare(strict_types=1);
session_start();

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


require_once __DIR__ . "/vendor/autoload.php";

// util
use App\Util\HKT;

// Xử lý HTTP request (GET, POST, SERVER)
use App\Core\Request;

// Xử lý router dựa vào request
use App\Core\Router;

// .env
use Dotenv\Dotenv;
$envRoot = dirname(__DIR__);
if (file_exists($envRoot . '/.env')) {
    Dotenv::createImmutable($envRoot)->load();
}

// Khai báo router gốc
// $router = new Router();

// Define routes (simple)
Router::get('/', 'HomeController@index');

// student
Router::get('/students','StudentController@index');
Router::get('/students/create','StudentController@create');
Router::post('/students','StudentController@store');
Router::get('/students/edit/{id}','StudentController@edit');

// teacher
Router::get('/teachers', 'TeacherController@index');

// course
Router::get('/courses', 'CourseController@index');

// $router->get('/students', 'StudentController@index');

// Dispatch

/**
 * Giải thích xíu chỗ này
 * 
 * giả sử như đường dẫn là http://localhost:8080/students/create
 * - Gọi hàm Request::createFromGlobals
 *      - tạo 1 instance của Request, chứa Method = GET, Path = students/create
 * - Router::get('/students/create','StudentController@create');
 * - Khớp route GET /students/create nên nó sẽ chạy hàm create trong class StudentController
 * - đây là hàm hiển thị form 
 * 
 * 
 * Ok giờ submit qua http://localhost:8080/students với phương thức POST
 * - thì lúc này cũng về lại file index và chạy tiếp Request::createFromGlobals
 *      - tạo 1 instance của Request, chứa Method = POST, Path = /students
 * - Router::post('/students','StudentController@store');
 * - Khớp route POST /students nên nó sẽ chạy hàm store trong class StudentController
 * - Lúc này mình sẽ sử lý các dữ liệu được lưu trữ ở instane request
 */
$request = Request::createFromGlobals();
HKT::dd($request);
Router::dispatch($request);