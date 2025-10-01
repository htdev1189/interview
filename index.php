<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Controller\StudentController;
use App\Controller\TeacherController;
use App\Controller\CourseController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Base path (nếu project nằm trong thư mục con)
$basePath = '/interview';
$uri = str_replace($basePath, '', $uri);

$method = $_SERVER['REQUEST_METHOD'];

switch (true) {
    /** -------- STUDENTS -------- */
    case $uri === '/students' && $method === 'GET':
        (new StudentController())->list();
        break;
    case preg_match('#^/students/edit/(\d+)$#', $uri, $matches) && $method === 'GET':
        (new StudentController())->editForm((int)$matches[1]);
        break;
    case preg_match('#^/students/view/(\d+)$#', $uri, $matches) && $method === 'GET':
        (new StudentController())->view((int)$matches[1]);
        break;
    case $uri === '/students/create' && $method === 'GET':
        (new StudentController())->createForm();
        break;
    case $uri === '/students' && $method === 'POST':
        (new StudentController())->store();
        break;
    case $uri === '/students/update' && $method === 'POST':
        (new StudentController())->update();
        break;
    case $uri === '/students/delete' && $method === 'POST':
        (new StudentController())->delete();
        break;
    case $uri === '/students/registerCourse' && $method === 'GET':
        (new StudentController())->registerCourseForm();
        break;
    case $uri === '/students/registerCourse' && $method === 'POST':
        (new StudentController())->registerCourse();
        break;
    
    /** -------- TEACHERS -------- */
    case $uri === '/teachers' && $method === 'GET':
        (new TeacherController())->list();
        break;
    case $uri === '/teachers/create' && $method === 'GET':
        (new TeacherController())->createForm();
        break;
    case $uri === '/teachers' && $method === 'POST':
        (new TeacherController())->store();
        break;
        break;
    case $uri === '/teachers/delete' && $method === 'POST':
        (new TeacherController())->delete();
        break;
    case preg_match('#^/teachers/edit/(\d+)$#', $uri, $matches) && $method === 'GET':
        (new TeacherController())->editForm((int)$matches[1]);
        break;
    case $uri === '/teachers/update' && $method === 'POST':
        (new TeacherController())->update();
        break;
    


    /** -------- COURSES -------- */
    case $uri === '/courses' && $method === 'GET':
        (new CourseController())->list();
        break;
    case $uri === '/courses/create' && $method === 'GET':
        (new CourseController())->createForm();
        break;
    case $uri === '/courses' && $method === 'POST':
        (new CourseController())->store();
        break;
    case $uri === '/courses/delete' && $method === 'POST':
        (new CourseController())->delete();
        break;
    case preg_match('#^/courses/edit/(\d+)$#', $uri, $matches) && $method === 'GET':
        (new CourseController())->editForm((int)$matches[1]);
        break;
    case $uri === '/courses/update' && $method === 'POST':
        (new CourseController())->update();
        break;

    default:
        http_response_code(404);
        echo "404 Not Found: $uri";
        break;
}
