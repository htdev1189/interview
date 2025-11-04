<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\CourseRepository;

class CourseService
{
    private CourseRepository $repository;

    public function __construct()
    {
        $this->repository = new CourseRepository();
    }

    /** Lấy danh sách khóa học */
    public function getAllCourses(): array
    {
        return $this->repository->getAll();
    }

    /** Lấy chi tiết 1 khóa học */
    public function findCourseById(int $id): ?array
    {
        return $this->repository->find($id);
    }

    /** Thêm khóa học mới */
    public function store(array $data)
    {
        try {
            return $this->repository->create($data);
        } catch (\Throwable $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    /** Cập nhật khóa học */
    public function update(array $data): bool
    {
        return $this->repository->update((int) $data['id'], $data);
    }

    /** Xóa khóa học */
    public function deleteCourse(int $id)
    {
        try {
            $source = $this->findCourseById($id);
            if ($source) {
                return $this->repository->delete($id);
            } else {
                throw new \Exception("Course khong ton tai");
            }
        } catch (\Throwable $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }
}
