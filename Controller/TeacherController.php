<?php
namespace App\Controller;

use App\Model\Teacher;
use App\Repository\TeacherRepository;
use App\Service\TeacherService;
use App\Core\Controller;

class TeacherController extends Controller{
    // dependency service
    private TeacherService $teacherService;

    public function __construct()
    {
        $repository = new TeacherRepository();
        $this->teacherService = new TeacherService($repository);
    }

    public function index(){
        $teachers = $this->teacherService->getAllTeachers();
        // render
        $this->render("teacher/list",[
            "title" => "Danh sách giáo viên",
            "teachers" => $teachers
        ]);
    }

    public function list(){
        $teachers = $this->teacherService->getAllTeachers();
        // render
        $this->render("teacher/list",[
            "title" => "Danh sách giáo viên",
            "teachers" => $teachers
        ]);
    }

    // render form create teacher
    public function createForm(){
        $this->render("teacher/create",[
            "title" => "Thêm Giáo Viên"
        ]);
    }
    // submit form create teacher
    public function store(){
        $teacher = new Teacher(
            null,
            $_POST['name'],
            $_POST['email'],
            $_POST['phone'],
            null
        );
        $this->teacherService->create($teacher);
        header("Location: /interview/teachers");
        exit;
    }
    public function editForm($id){
        $teacher = $this->teacherService->findByID($id);
        $this->render("teacher/edit",[
            "title" => "Chỉnh sửa giáo viên",
            "teacher" => $teacher
        ]);
    }
    public function update(){
        $teacher = new Teacher(
            $_POST['id'],
            $_POST['name'],
            $_POST['email'],
            $_POST['phone']
        );
        $this->teacherService->update($teacher);
        header("Location: /interview/teachers");
        exit();
    }
    public function delete(){
        $id = $_POST['id'];
        $this->teacherService->delete($id);        
        header("Location: /interview/teachers");
        exit;
    }
}