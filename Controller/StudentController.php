<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\StudentService;
use App\Repository\StudentRepository;
use App\Controller\BaseController;

use App\Model\Student;
use App\Repository\CourseRepository;
use App\Service\CourseService;

class StudentController extends BaseController
{
    private StudentService $studentService;
    private CourseService $courseService;

    public function __construct()
    {
        $this->studentService = new StudentService(new StudentRepository());
        $this->courseService = new CourseService(new CourseRepository());
    }

    /** Hiển thị danh sách sinh viên */
    public function index(): void
    {
        $students = $this->studentService->getAllStudents();
        foreach ($students as $s) {
            echo $s->id . " - " . $s->name . " - " . $s->email . "<br>";
        }
    }

    /** Hiển thị chi tiết 1 sinh viên */
    public function show(int $id): void
    {
        $student = $this->studentService->getStudentById($id);
        if ($student) {
            echo "ID: {$student->id}<br>";
            echo "Name: {$student->name}<br>";
            echo "Email: {$student->email}<br>";
            echo "Phone: {$student->phone}<br>";
        } else {
            echo "Không tìm thấy sinh viên.";
        }
    }

    /** Xử lý thêm mới sinh viên */
    public function create(array $data): void
    {
        try {
            $this->studentService->createStudent(
                $data["name"],
                $data["email"],
                $data["phone"]
            );
            echo "Thêm sinh viên thành công!";
        } catch (\Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function list()
    {
        $students = (new StudentService(new StudentRepository()))->getAllStudents();
        $this->render('student/list', [
            'title'    => 'Danh sách sinh viên',
            'students' => $students
        ]);
    }

    public function createForm()
    {
        $this->render('student/create', [
            'title'    => 'Thêm mới sinh viên'
        ]);
    }
    public function store()
    {

        // Theo kiến trúc MVC + Service + Repository, 
        // thì Controller chính là nơi “gom dữ liệu từ request” và chuyển nó thành Model (ở đây là Student) để chuyền qua Service.
        $student = new Student(
            null,
            $_POST['name'],
            $_POST['email'],
            $_POST['phone'],
            null
        );
        $this->studentService->createStudent($student);
        header("Location: /interview/students");
        exit;
    }

    public function editForm($id)
    {
        $student = (new StudentService(new StudentRepository()))->getStudentById($id);
        if (!$student) {
            echo "Không tìm thấy sinh viên.";
            return;
        }
        $this->render('student/edit', [
            'title'    => 'Cập nhật thông tin sinh viên',
            'student' => $student
        ]);
    }

    public function update()
    {
        $student = new Student(
            $_POST['id'],
            $_POST['name'],
            $_POST['email'],
            $_POST['phone'],
            null
        );

        $this->studentService->updateStudent($student);
        header("Location: /interview/students");
        exit;
    }
    public function delete()
    {
        $id = $_POST['id'];
        // Xử lý xóa sinh viên theo id
        $this->studentService->deleteStudent($id);
        header("Location: /interview/students");
        exit;
    }

    // register course form
    public function registerCourseForm()
    {
        $this->render("student/registerCourse", [
            "title" => "Đăng ký khóa học",
            "students" => $this->studentService->getAllStudents(),
            "courses" => $this->courseService->getAll()
        ]);
    }

    // register course form
    public function registerCourse()
    {
        $studentId = $_POST['student_id'] ?? null;
        $courseId = $_POST['course_id'] ?? null;

        $this->studentService->registerCourse($studentId, $courseId);
        header("Location: /interview/students");
        exit;
    }

    // view
    public function view($id)
    {

        $student = $this->studentService->getStudentById($id);

        // kiem tra ngay tai controller
        if (!$student) {
            // Cách 1: hiển thị 404
            http_response_code(404);
            echo "Student not found!";
            return;
        }

        $this->render("student/view", [
            "title" => "Thông tin student",
            "student" => $this->studentService->getStudentWithCourses($id)
        ]);
    }
}
