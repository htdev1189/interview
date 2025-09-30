<?php
namespace App\Service;

use App\Model\Course;
use App\Repository\CourseRepository;

class CourseService
{
    private $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    // Lấy danh sách course
    public function getAll()
    {
        return $this->courseRepository->getAll();
    }

    // Tạo course mới
    public function create($course)
    {
        if(empty($course->title) || empty($course->teacher_id)){
            throw new \Exception("Invalid data");
        }

        return $this->courseRepository->create($course);
    }

    // Lấy course theo id
    public function getCourseById($id)
    {
        return $this->courseRepository->findById($id);
    }

    // Cập nhật course
    public function update($course)
    {
        return $this->courseRepository->update($course);
    }

    // Xóa course
    public function delete($id)
    {
        return $this->courseRepository->delete($id);
    }

    // Lấy danh sách course theo teacher
    public function getCoursesByTeacher($teacherId)
    {
        return $this->courseRepository->findByTeacherId($teacherId);
    }
}
