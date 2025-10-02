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
    public function findByID($id)
    {
        $teacher = $this->teacherRepository->getById($id);
        if ($teacher && $teacher->status == 1) {
            return $teacher;
        }
        return null;
    }

    // Cập nhật teacher
    public function update($teacher)
    {
        if (empty($teacher->name) || empty($teacher->email) || empty($teacher->phone)) {
            throw new \Exception("Invalid data");
        }
        return $this->teacherRepository->update($teacher);
    }

    // Xóa teacher
    public function delete($id)
    {
        return $this->teacherRepository->delete($id);
    }
}
