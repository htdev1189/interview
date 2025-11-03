<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Controller;
use App\Core\Request;
use App\Model\Student;
use App\Service\StudentService;
use App\Service\CourseService;
use App\Util\HKT;

class StudentController extends Controller
{
    private StudentService $studentService;
    private CourseService $courseService;

    public function __construct()
    {
        $this->studentService = new StudentService();
        // $this->courseService  = new CourseService();
    }

    /** Hiển thị danh sách sinh viên */
    public function index(): void
    {
        $students = $this->studentService->getAllStudents();
        // HKT::dd($students);
        $this->render('student/list', [
            'title'    => 'Danh sách sinh viên',
            'students' => $students
        ]);
    }

    /** Form tạo sinh viên */
    public function create(): void
    {
        $this->render('student/create', [
            'title' => 'Thêm mới sinh viên'
        ]);
    }

    /** Lưu sinh viên mới */
    public function store(Request $request): void
    {
        $validated = $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required'
        ]);

        try {
            $this->studentService->createStudent($validated);
            $_SESSION['success'] = "Tạo sinh viên thành công!";
        } catch (\Exception $e) {
            $_SESSION['error'] = "Lỗi khi tạo sinh viên: " . $e->getMessage();
        }

        header("Location: /interview/students");
        exit;
    }

    /** Sửa thông tin sinh viên */
    public function edit(int $id): void
    {
        $student = $this->studentService->getStudentById($id);
        if (!$student) {
            $this->render("error/404", ['error' => "Không tìm thấy sinh viên"]);
            return;
        }

        $this->render('student/edit', [
            'title'   => 'Cập nhật sinh viên',
            'student' => $student
        ]);
    }

    /** Cập nhật sinh viên */
    public function update(Request $request): void
    {
        $validated = $request->validate([
            'id'    => 'required|numeric',
            'name'  => 'required',
            'email' => "required|email|unique:students,email,{$request->input('id')}",
            'phone' => "required|unique:students,phone,{$request->input('id')}"
        ]);


        try {
            $this->studentService->updateStudent($validated);
            $_SESSION['success'] = "Cập nhật sinh viên thành công!";
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header("Location: /interview/students");
        exit;
    }

    /** Xóa sinh viên */
    public function destroy(int $id): void
    {
        try {
            $this->studentService->deleteStudent($id);
            $_SESSION['success'] = "Xóa sinh viên thành công!";
        } catch (\Exception $e) {
            $_SESSION['error'] = "Xóa thất bại: " . $e->getMessage();
        }

        header("Location: /interview/students");
        exit;
    }

    /** Xem chi tiết sinh viên */
    public function view(int $id): void
    {
        $student = $this->studentService->getStudentWithCourses($id);

        if (!$student) {
            http_response_code(404);
            $this->render("error/404", ["error" => "Không tìm thấy sinh viên"]);
            return;
        }

        $this->render("student/view", [
            "title"   => "Chi tiết sinh viên",
            "student" => $student
        ]);
    }

    /** Form đăng ký khóa học */
    public function registerCourseForm(): void
    {
        $this->render("student/registerCourse", [
            "title"    => "Đăng ký khóa học",
            "students" => $this->studentService->getAllStudents(),
            "courses"  => $this->courseService->getAll()
        ]);
    }

    /** Xử lý đăng ký khóa học */
    public function registerCourse(Request $request): void
    {
        $studentId = $request->input('student_id');
        $courseId  = $request->input('course_id');

        try {
            $this->studentService->registerCourse($studentId, $courseId);
            $_SESSION['success'] = "Đăng ký khóa học thành công!";
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header("Location: /interview/students");
        exit;
    }
}
