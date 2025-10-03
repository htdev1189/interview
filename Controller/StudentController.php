<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\StudentService;
use App\Repository\StudentRepository;
use App\Controller\BaseController;
use App\Core\Controller;
use App\Core\Request;
use App\Http\Request\StudentRequest;
use App\Model\Student;
use App\Repository\CourseRepository;
use App\Service\CourseService;
use App\Util\HKT;

class StudentController extends Controller
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
        $this->render('student/list', [
            'title'    => 'Danh sách sinh viên',
            'students' => $students
        ]);
    }

    public function create()
    {
        $this->render('student/create', [
            'title'    => 'Thêm mới sinh viên'
        ]);
    }
    public function store(Request $request)
    {
        $student = new Student(
            null,
            $request->input('name'),
            $request->input('email'),
            $request->input('phone'),
            null
        );
        try {
            $this->studentService->createStudent($student);
            $_SESSION['success'] = "create student success !!!";
            header("Location: /interview/students");
            exit;
        } catch (\Throwable $th) {
            $_SESSION['error'] = "create student failed !!!";
            header("Location: /interview/students");
            exit;
        }
    }
    public function edit($id)
    {
        $student = $this->studentService->getStudentById($id);
        if ($student) {
            $this->render("student/edit", [
                'title'    => 'Chinh sua sinh viên',
                'student' => $student
            ]);
            return;
        }
        $this->render("error/404", [
            'error' => "Student not found !!!"
        ]);
    }

    public function update(Request $request)
    {
        $student = new Student(
            (int) $request->input('id'),
            trim($request->input('name')),
            trim($request->input('email')),
            trim($request->input('phone'))
        );
        try {
            $this->studentService->updateStudent($student);
            $_SESSION['success'] = "update student success !!!";
            header("Location: /interview/students");
            exit;
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header("Location: /interview/students");
            exit;
        }
    }
    public function destroy($id){
        $deleted = $this->studentService->deleteStudent($id);

        if ($deleted) {
            $_SESSION['success'] = "Student $id deleted successfully.";
            header("Location: /interview/students");
            exit;
        } else {
            $_SESSION['success'] = "Failed to delete student !!!";
            header("Location: /interview/students");
            exit;
        }
    }
    /** Hiển thị chi tiết 1 sinh viên */
    // public function show(int $id): void
    // {
    //     $student = $this->studentService->getStudentById($id);
    //     if ($student) {
    //         echo "ID: {$student->id}<br>";
    //         echo "Name: {$student->name}<br>";
    //         echo "Email: {$student->email}<br>";
    //         echo "Phone: {$student->phone}<br>";
    //     } else {
    //         echo "Không tìm thấy sinh viên.";
    //     }
    // }

    /** Xử lý thêm mới sinh viên */
    // public function create(array $data): void
    // {
    //     try {
    //         $this->studentService->createStudent(
    //             $data["name"],
    //             $data["email"],
    //             $data["phone"]
    //         );
    //         echo "Thêm sinh viên thành công!";
    //     } catch (\Exception $e) {
    //         echo "Lỗi: " . $e->getMessage();
    //     }
    // }

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
    // public function store()
    // {
    //     try {
    //         $student = StudentRequest::fromPost($_POST);
    //         $this->studentService->createStudent($student);
    //         $_SESSION['success'] = "create student success !!!";
    //         header("Location: /interview/students");
    //         exit;
    //     } catch (\Exception $e) {
    //         $_SESSION['error'] = $e->getMessage();
    //         header("Location: /interview/students");
    //         exit;
    //         // $this->render("student/error", [
    //         //     "title" => "Thêm mới sinh viên",
    //         //     "error" => $e->getMessage()
    //         // ]);
    //     }
    // }

    public function editForm($id)
    {
        $student = $this->studentService->getStudentById($id);
        if (!$student) {
            $this->render("error/404", [
                "error" => "Không tìm thấy sinh viên"
            ]);
            return;
        }

        $this->render('student/edit', [
            'title'    => 'Cập nhật thông tin sinh viên',
            'student' => $student
        ]);
    }

    // public function update()
    // {
    //     try {
    //         $student = StudentRequest::fromPost($_POST);
    //         $this->studentService->updateStudent($student);
    //         $_SESSION['success'] = "update student success !!!";
    //         header("Location: /interview/students");
    //         exit;
    //     } catch (\Exception $e) {
    //         $_SESSION['error'] = $e->getMessage();
    //         header("Location: /interview/students");
    //         exit;
    //     }
    // }
    public function delete()
    {
        $id = $_POST['id'];
        $student = $this->studentService->getStudentById($id);
        if (!$student) {
            $this->render("error/404", [
                "error" => "Không tìm thấy sinh viên"
            ]);
            return;
        }
        try {
            $this->studentService->deleteStudent($id);
            header("Location: /interview/students");
            exit;
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header("Location: /interview/students");
            exit;
        }
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
