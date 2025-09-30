<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\StudentService;
use App\Repository\StudentRepository;
use App\Controller\BaseController;

use App\Model\Student;


class StudentController extends BaseController
{
    private StudentService $studentService;

    public function __construct()
    {
        $repository = new StudentRepository();
        $this->studentService = new StudentService($repository);
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

    public function list() {
        $students = (new StudentService(new StudentRepository()))->getAllStudents();
        $this->render('student/list', [
            'title'    => 'Danh sách sinh viên',
            'students' => $students
        ]);
    }

    public function createForm(){
        $this->render('student/create', [
            'title'    => 'Thêm mới sinh viên'
        ]);
    }
    public function store(){

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

    public function editForm($id){
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

    public function update(){
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
    public function delete(){
        $id = $_POST['id'];
        // Xử lý xóa sinh viên theo id
        $this->studentService->deleteStudent($id);        
        header("Location: /interview/students");
        exit;
    }


}
