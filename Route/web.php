<?php
namespace App\Route;

// Xử lý HTTP request (GET, POST, SERVER)
use App\Core\Request;

// Xu ly URI
use App\Core\Router;

// Define routes (simple)
Router::get('/', 'HomeController@index');

// student
Router::get('/students','StudentController@index');
Router::get('/students/create','StudentController@create');
Router::post('/students','StudentController@store');
Router::get('/students/edit/{id}','StudentController@edit');
Router::post('/students/update', 'StudentController@update');
Router::post('/students/delete/{id}', 'StudentController@destroy');

// teacher
Router::get('/teachers', 'TeacherController@index');
Router::get('/teachers/create','TeacherController@create');
Router::post('/teachers','TeacherController@store');
Router::get('/teachers/edit/{id}','TeacherController@edit');
Router::post('/teachers/update', 'TeacherController@update');
Router::post('/teachers/delete/{id}', 'TeacherController@destroy');

// course
Router::get('/courses', 'CourseController@index');
Router::get('/courses/create','CourseController@create');
Router::post('/courses','CourseController@store');
Router::get('/courses/edit/{id}','CourseController@edit');
Router::post('/courses/update', 'CourseController@update');
Router::post('/courses/delete/{id}', 'CourseController@destroy');

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
Router::dispatch($request);