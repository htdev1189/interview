<?php
namespace App\Service;

use App\Model\Teacher;
use App\Repository\TeacherRepository;

class TeacherService
{
    private $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    // Lấy danh sách tất cả teacher
    public function getAllTeachers()
    {
        return $this->teacherRepository->getAll();
    }

    // Tạo teacher mới
    public function create($teacher)
    {
        if (empty($teacher->name) || empty($teacher->email) || empty($teacher->phone)) {
            throw new \Exception("Invalid data");
        }
        return $this->teacherRepository->create($teacher);
    }

    // Lấy teacher theo id
    public function getTeacherById($id)
    {
        return $this->teacherRepository->getById($id);
    }

    // Cập nhật teacher
    public function updateTeacher($id, $name, $email, $phone)
    {
        $teacher = new Teacher($id, $name, $email, $phone);
        return $this->teacherRepository->update($teacher);
    }

    // Xóa teacher
    public function deleteTeacher($id)
    {
        return $this->teacherRepository->delete($id);
    }
}
