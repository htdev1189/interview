<?php

namespace App\Repository;

use App\Model\Student;

class StudentRepository
{
    protected Student $model;

    public function __construct()
    {
        $this->model = new Student();
    }

    /**
     * Thêm sinh viên mới
     */
    public function create(array $data)
    {
        try {
            return $this->model->create($data);
        } catch (\Exception $e) {
            throw new \RuntimeException("Lỗi khi thêm sinh viên: " . $e->getMessage());
        }
    }

    /**
     * Lấy tất cả sinh viên còn hoạt động
     */
    public function findAll(): array
    {
        try {
            return $this->model->where('status', '=', 1)->get();
        } catch (\Exception $e) {
            throw new \RuntimeException("Lỗi khi lấy danh sách sinh viên: " . $e->getMessage());
        }
    }

    /**
     * Tìm sinh viên theo ID
     */
    public function findById(int $id): ?array
    {
        try {
            return $this->model->find($id);
        } catch (\Exception $e) {
            throw new \RuntimeException("Lỗi khi tìm sinh viên: " . $e->getMessage());
        }
    }

    /**
     * Cập nhật thông tin sinh viên
     */
    public function update(int $id, array $data)
    {
        try {
            return $this->model->update($id, $data);
        } catch (\Exception $e) {
            throw new \RuntimeException("Lỗi khi cập nhật sinh viên: " . $e->getMessage());
        }
    }

    /**
     * Xóa (hoặc disable) sinh viên
     */
    public function delete(int $id)
    {
        try {
            // nếu bạn dùng "status = 0" là soft delete
            return $this->model->update($id, ['status' => 0]);
        } catch (\Exception $e) {
            throw new \RuntimeException("Lỗi khi xóa sinh viên: " . $e->getMessage());
        }
    }

    /**
     * Lấy thông tin sinh viên và danh sách khóa học đã đăng ký
     */
    public function findWithCourses(int $id)
    {
        try {
            return $this->model->withCourses($id);
        } catch (\Exception $e) {
            throw new \RuntimeException("Lỗi khi lấy thông tin khóa học của sinh viên: " . $e->getMessage());
        }
    }

    /**
     * Gán sinh viên vào khóa học
     */
    public function registerCourse(int $studentId, int $courseId)
    {
        try {
            return $this->model->registerCourse($studentId, $courseId);
        } catch (\Exception $e) {
            throw new \RuntimeException("Lỗi khi đăng ký khóa học: " . $e->getMessage());
        }
    }
}
