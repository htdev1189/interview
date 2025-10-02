<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Router;
use App\Controller\StudentController;
use App\Controller\TeacherController;
use App\Controller\CourseController;

$router = new Router();

// Students
$router->add('GET', '#^/students$#', [new StudentController(), 'list']);
$router->add('GET', '#^/students/create$#', [new StudentController(), 'createForm']);
$router->add('POST', '#^/students$#', [new StudentController(), 'store']);
$router->add('GET', '#^/students/edit/(\d+)$#', [new StudentController(), 'editForm']);
$router->add('POST', '#^/students/update$#', [new StudentController(), 'update']);
$router->add('POST', '#^/students/delete$#', [new StudentController(), 'delete']);
$router->add('GET', '#^/students/view/(\d+)$#', [new StudentController(), 'view']);
$router->add('GET', '#^/students/registerCourse$#', [new StudentController(), 'registerCourseForm']);
$router->add('POST', '#^/students/registerCourse$#', [new StudentController(), 'registerCourse']);

// Teachers
$router->add('GET', '#^/teachers$#', [new TeacherController(), 'list']);
$router->add('GET', '#^/teachers/create$#', [new TeacherController(), 'createForm']);
$router->add('POST', '#^/teachers$#', [new TeacherController(), 'store']);
$router->add('GET', '#^/teachers/edit/(\d+)$#', [new TeacherController(), 'editForm']);
$router->add('POST', '#^/teachers/update$#', [new TeacherController(), 'update']);
$router->add('POST', '#^/teachers/delete$#', [new TeacherController(), 'delete']);

// Courses
$router->add('GET', '#^/courses$#', [new CourseController(), 'list']);
$router->add('GET', '#^/courses/create$#', [new CourseController(), 'createForm']);
$router->add('POST', '#^/courses$#', [new CourseController(), 'store']);
$router->add('GET', '#^/courses/edit/(\d+)$#', [new CourseController(), 'editForm']);
$router->add('POST', '#^/courses/update$#', [new CourseController(), 'update']);
$router->add('POST', '#^/courses/delete$#', [new CourseController(), 'delete']);

// Dispatch
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = '/interview';
$uri = str_replace($basePath, '', $uri);
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($uri, $method);
