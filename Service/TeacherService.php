<?php

namespace App\Service;

use App\Model\Teacher;
use App\Repository\TeacherRepository;
use App\Util\HKT;

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
    public function findByID($id)
    {
        $teacher = $this->teacherRepository->getById($id);
        if ($teacher && $teacher->status == 1) {
            return $teacher;
        }
        return null;
    }

    // Cập nhật teacher
    public function update(Teacher $teacher)
    {
        
        if (empty($teacher->id)) {
            throw new \Exception("Teacher ID is required");
        }
        if (empty($teacher->name)) {
            throw new \Exception("Name is required");
        }
        if (!filter_var($teacher->email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("Invalid email format");
        }
        if (empty($teacher->phone)) {
            throw new \Exception("Phone is required");
        }

        return $this->teacherRepository->update($teacher);
    }

    // Xóa teacher
    public function delete($id)
    {
        return $this->teacherRepository->delete((int)$id);
    }
}
