<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\StudentRepository;

class StudentService
{
    // Business logic layer

    private $studentRepository;
    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    // get all students
    public function getAllStudents()
    {
        return $this->studentRepository->findAll();
    }

    // get student by id
    public function getStudentById($id)
    {
        $student = $this->studentRepository->findById($id);
        if (!$student) {
            return null; // hoặc throw new Exception("Student not found");
        }
        return $student;
    }

    // create student
    public function createStudent($student)
    {
        try {
            $this->studentRepository->create($student);
        } catch (\RuntimeException $e) {
            throw $e; // tiếp tục ném ra để Controller bắt
        }
    }

    // update student
    public function updateStudent($student)
    {
        try {
            return $this->studentRepository->update($student);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    // delete student
    public function deleteStudent($id)
    {
        if (empty($id)) {
            throw new \Exception("Invalid data");
        }
        return $this->studentRepository->delete($id);
    }

    public function registerCourse($studentId, $courseId)
    {
        return $this->studentRepository->registerCourse($studentId, $courseId);
    }

    public function getStudentWithCourses($id)
    {
        return $this->studentRepository->findWithCourses($id);
    }
}
