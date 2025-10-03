<?php
namespace App\Controller;

use App\Model\Course;
use App\Repository\CourseRepository;
use App\Repository\TeacherRepository;
use App\Service\CourseService;
use App\Service\TeacherService;
use App\Core\Controller;
use App\Core\Request;

class CourseController extends Controller {
    private CourseService $courseService;
    private TeacherService $teacherService;
    public function __construct()
    {
        $repository = new CourseRepository();
        $this->courseService = new CourseService(new CourseRepository());
        $this->teacherService = new TeacherService(new TeacherRepository);
    }
    public function index(){
        $cousers = $this->courseService->getAll();
        $this->render('course/list', [
            'title'    => 'Danh sách khóa học',
            'courses' => $cousers
        ]);
    }
    public function create()
    {
        $this->render('course/create', [
            'title'    => 'Add new course',
            'teachers' => $this->teacherService->getAllTeachers()
        ]);
    }
    public function store(Request $request)
    {
        $course = new Course(
            null,
            $request->input('title'),
            $request->input('description'),
            $request->input('teacher_id'),
        );
        try {
            $this->courseService->create($course);
            $_SESSION['success'] = "create course success !!!";
            header("Location: /interview/courses");
            exit;
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header("Location: /interview/courses");
            exit;
        }
    }

    public function edit($id)
    {
        $course = $this->courseService->getCourseById($id);
        if ($course) {
            $this->render("course/edit", [
                'title'    => 'Edit course',
                'course' => $course,
                'teachers' => $this->teacherService->getAllTeachers()
            ]);
            return;
        }
        $this->render("error/404", [
            'error' => "course not found !!!"
        ]);
    }
    public function update(Request $request)
    {
        $course = new Course(
            (int) $request->input('id'),
            trim($request->input('title')),
            trim($request->input('description')),
            (int) $request->input('teacher_id')
        );
        try {
            $this->courseService->update($course);
            $_SESSION['success'] = "update course success !!!";
            header("Location: /interview/courses");
            exit;
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header("Location: /interview/courses");
            exit;
        }
    }
    // public function list(){
    //     $cousers = $this->courseService->getAll();
    //     $this->render('course/list', [
    //         'title'    => 'Danh sách khóa học',
    //         'courses' => $cousers
    //     ]);
    // }

    // // create form
    // public function createForm(){
    //     $this->render('course/create', [
    //         'title'    => 'Thêm mới khóa học',
    //         'teachers' => $this->teacherRepository->getAll()
    //     ]);
    // }

    // // store
    // public function store(){
    //     $course = new Course(
    //         null,
    //         $_POST['title'],
    //         $_POST['description'],
    //         $_POST['teacher_id'],
    //         null
    //     );
    //     $this->courseService->create($course);
    //     header("Location: /interview/courses");
    //     exit;
    // }

    // // xóa / ẩn khóa học
    // public function delete(){
    //     $id = $_POST['id'];
    //     $this->courseService->delete($id);        
    //     header("Location: /interview/courses");
    //     exit;
    // }

    // public function editForm($id){
    //     $course = $this->courseService->getCourseById($id);
    //     if (!$course) {
    //         echo "Không tìm thấy khóa học.";
    //         return;
    //     }
    //     $this->render('course/edit', [
    //         'title'    => 'Cập nhật thông tin khóa học',
    //         'course' => $course,
    //         'teachers' => $this->teacherRepository->getAll()
    //     ]);
    // }
    // public function update(){
    //     $course = new Course(
    //         $_POST['id'],
    //         $_POST['title'],
    //         $_POST['description'],
    //         $_POST['teacher_id'],
    //         $_POST['created_at']
    //     );
    //     $this->courseService->update($course);
    //     header("Location: /interview/courses");
    //     exit;
    // }

    

}
