<?php
namespace App\Route;

// Xử lý HTTP request (GET, POST, SERVER)
use App\Core\Request;

// Xu ly URI
use App\Core\Router;

// test middleware

Router::get('/login', 'AuthController@showLoginForm')->name('login');
Router::post('/login', 'AuthController@login')->name('login');
Router::post('/logout', 'AuthController@logout')->name('logout');

// group yêu cầu login
Router::group(['middleware' => 'AuthMiddleware'], function () {
    Router::get('/', 'HomeController@index')->name('home');
    Router::get('/students', 'StudentController@index')->name('student.show');
});



// // login routes
// Router::get('/login', 'AuthController@showLoginForm')->name('login');
// Router::post('/login', 'AuthController@login')->name('login');
// Router::post('/logout', 'AuthController@logout')->name('logout');


// // Define routes (simple)
// Router::get('/', 'HomeController@index')->name('home');


// // student
// Router::get('/students','StudentController@index')->name('student.show');
// Router::get('/students/create','StudentController@create')->name('student.create');
// Router::post('/students','StudentController@store')->name('student.store');
// Router::get('/students/edit/{id}','StudentController@edit')->name('student.edit');
// Router::post('/students/update', 'StudentController@update')->name('studentupdate');
// Router::post('/students/delete/{id}', 'StudentController@destroy')->name('student.destroy');

// // teacher
// Router::get('/teachers', 'TeacherController@index')->name('teacher.show');
// Router::get('/teachers/create','TeacherController@create')->name('teacher.create');
// Router::post('/teachers','TeacherController@store')->name('teacher.store');
// Router::get('/teachers/edit/{id}','TeacherController@edit')->name('teacher.edit');
// Router::post('/teachers/update', 'TeacherController@update')->name('teacher.update');
// Router::post('/teachers/delete/{id}', 'TeacherController@destroy')->name('teacher.destroy');

// // course
// Router::get('/courses', 'CourseController@index')->name('course.show');
// Router::get('/courses/create','CourseController@create')->name('course.create');
// Router::post('/courses','CourseController@store')->name('course.store');
// Router::get('/courses/edit/{id}','CourseController@edit')->name('course.edit');
// Router::post('/courses/update', 'CourseController@update')->name('course.update');
// Router::post('/courses/delete/{id}', 'CourseController@destroy')->name('course.destroy');

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