<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\StudentRepository;

class StudentService
{
    private StudentRepository $studentRepository;

    public function __construct()
    {
        $this->studentRepository = new StudentRepository();
    }

    /** Lấy tất cả sinh viên */
    public function getAllStudents(): array
    {
        return $this->studentRepository->findAll();
    }

    /** Lấy sinh viên theo ID */
    public function getStudentById(int $id): ?array
    {
        $student = $this->studentRepository->findById($id);
        return $student ?: null;
    }

    /** Tạo sinh viên mới */
    public function createStudent(array $data): int
    {
        try {
            return $this->studentRepository->create($data);
        } catch (\Throwable $e) {
            throw new \RuntimeException("Lỗi khi tạo sinh viên: " . $e->getMessage());
        }
    }

    /** Cập nhật sinh viên */
    public function updateStudent(array $data): bool
    {
        if (empty($data['id'])) {
            throw new \InvalidArgumentException("Thiếu ID sinh viên");
        }

        try {
            return $this->studentRepository->update((int) $data['id'], $data);
        } catch (\Throwable $e) {
            throw new \RuntimeException("Lỗi khi cập nhật sinh viên: " . $e->getMessage());
        }
    }

    /** Xóa sinh viên */
    public function deleteStudent(int $id): bool
    {
        if (!$id) {
            throw new \InvalidArgumentException("ID không hợp lệ");
        }

        try {
            return $this->studentRepository->delete($id);
        } catch (\Throwable $e) {
            throw new \RuntimeException("Lỗi khi xóa sinh viên: " . $e->getMessage());
        }
    }

    /** Lấy sinh viên cùng khóa học */
    public function getStudentWithCourses(int $id): ?array
    {
        return $this->studentRepository->findWithCourses($id);
    }

    /** Đăng ký khóa học cho sinh viên */
    public function registerCourse(int $studentId, int $courseId): bool
    {
        return $this->studentRepository->registerCourse($studentId, $courseId);
    }
}
