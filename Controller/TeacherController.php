<?php

namespace App\Controller;

use App\Model\Teacher;
use App\Repository\TeacherRepository;
use App\Service\TeacherService;
use App\Core\Controller;
use App\Core\Request;
use App\Util\HKT;

class TeacherController extends Controller
{
    // dependency service
    private TeacherService $service;

    public function __construct()
    {
        $this->service = new TeacherService();
    }

    // list views
    public function index(){

        // get all teacher from db
        $teachers = $this->service->getAll();

        // render views
        $this->render("teacher/list",[
            "title" => "List Teacher",
            "teachers" => $teachers
        ]);

    }

    // form create
    public function create(){
        // render views
        $this->render("teacher/create",[
            "title" => "Create Teacher",
        ]);
    }

    // store
    public function store(Request $request){
        $validated = $request->validate(
            [
                'id'    => 'required|numeric',
                'name'  => 'required',
                'email' => "required|email|unique:techears,email,{$request->input('id')}",
                'phone' => "required|unique:techears,phone,{$request->input('id')}"
            ]
        );

        try {
            $this->service->create($validated);
            $_SESSION['success'] = "Tạo sinh viên thành công!";
        } catch (\Exception $e) {
            $_SESSION['error'] = "Lỗi khi tạo sinh viên: " . $e->getMessage();
        }

        header("Location: /interview/students");
        exit;
    }

    // public function index()
    // {
    //     $teachers = $this->teacherService->getAllTeachers();
    //     // render
    //     $this->render("teacher/list", [
    //         "title" => "Danh sách giáo viên",
    //         "teachers" => $teachers
    //     ]);
    // }

    // public function create()
    // {
    //     $this->render('teacher/create', [
    //         'title'    => 'Create New Teacher'
    //     ]);
    // }

    // public function store(Request $request)
    // {
    //     $teacher = new Teacher(
    //         null,
    //         $request->input('name'),
    //         $request->input('email'),
    //         $request->input('phone'),
    //         1,
    //         date('Y-m-d H:i:s')
    //     );
    //     try {
    //         $this->teacherService->create($teacher);
    //         $_SESSION['success'] = "create teacher success !!!";
    //         header("Location: /interview/teachers");
    //         exit;
    //     } catch (\Throwable $th) {
    //         $_SESSION['error'] = "create teacher failed !!!";
    //         header("Location: /interview/teachers");
    //         exit;
    //     }
    // }
    // public function edit($id)
    // {
    //     $teacher = $this->teacherService->findByID($id);
    //     if ($teacher) {
    //         $this->render("teacher/edit", [
    //             'title'    => 'Edit teacher',
    //             'teacher' => $teacher
    //         ]);
    //         return;
    //     }
    //     $this->render("error/404", [
    //         'error' => "Teacher not found !!!"
    //     ]);
    // }
    // public function update(Request $request)
    // {
    //     $teacher = new Teacher(
    //         $request->input('id'),
    //         $request->input('name'),
    //         $request->input('email'),
    //         $request->input('phone')
    //     );

    //     try {
    //         $this->teacherService->update($teacher);
    //         $_SESSION['success'] = "update teacher success !!!";
    //         header("Location: /interview/teachers");
    //         exit;
    //     } catch (\Exception $e) {
    //         $_SESSION['error'] = $e->getMessage();
    //         header("Location: /interview/teachers");
    //         exit;
    //     }
    // }

    // public function destroy($id)
    // {
    //     $deleted = $this->teacherService->delete($id);
    //     if ($deleted) {
    //         $_SESSION['success'] = "teacher $id deleted successfully.";
    //     } else {
    //         $_SESSION['error'] = "Failed to delete teacher !!!";
    //     }
    //     header("Location: /interview/teachers");
    //     exit;
    // }

    // public function list(){
    //     $teachers = $this->teacherService->getAllTeachers();
    //     // render
    //     $this->render("teacher/list",[
    //         "title" => "Danh sách giáo viên",
    //         "teachers" => $teachers
    //     ]);
    // }

    // // render form create teacher
    // public function createForm(){
    //     $this->render("teacher/create",[
    //         "title" => "Thêm Giáo Viên"
    //     ]);
    // }
    // // submit form create teacher
    // public function store(){
    //     $teacher = new Teacher(
    //         null,
    //         $_POST['name'],
    //         $_POST['email'],
    //         $_POST['phone'],
    //         null
    //     );
    //     $this->teacherService->create($teacher);
    //     header("Location: /interview/teachers");
    //     exit;
    // }
    // public function editForm($id){
    //     $teacher = $this->teacherService->findByID($id);
    //     $this->render("teacher/edit",[
    //         "title" => "Chỉnh sửa giáo viên",
    //         "teacher" => $teacher
    //     ]);
    // }
    // public function update(){
    //     $teacher = new Teacher(
    //         $_POST['id'],
    //         $_POST['name'],
    //         $_POST['email'],
    //         $_POST['phone']
    //     );
    //     $this->teacherService->update($teacher);
    //     header("Location: /interview/teachers");
    //     exit();
    // }
    // public function delete(){
    //     $id = $_POST['id'];
    //     $this->teacherService->delete($id);        
    //     header("Location: /interview/teachers");
    //     exit;
    // }
}
