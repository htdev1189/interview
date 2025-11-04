<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Course;

class CourseRepository
{
    private Course $model;

    public function __construct()
    {
        $this->model = new Course();
    }

    /** Lấy tất cả */
    public function getAll(): array
    {
        return $this->model->all('status = 1');
    }

    /** Tìm theo ID */
    public function find(int $id): ?array
    {
        return $this->model->find($id);
    }

    /** Tạo mới */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /** Cập nhật */
    public function update(int $id, array $data): bool
    {
        return $this->model->update($id, $data);
    }

    /** Xóa */
    public function delete(int $id): bool
    {
        return $this->model->delete($id);
    }
}
