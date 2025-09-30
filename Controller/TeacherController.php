<?php
namespace App\Controller;

use App\Model\Teacher;
use App\Repository\TeacherRepository;
use App\Service\TeacherService;

class TeacherController extends BaseController{
    // dependency service
    private TeacherService $teacherService;

    public function __construct()
    {
        $repository = new TeacherRepository();
        $this->teacherService = new TeacherService($repository);
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
}