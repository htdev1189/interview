<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Router;
use App\Service\CourseService;
use App\Service\TeacherService;
use App\Util\HKT;

class CourseController extends Controller
{
    private CourseService $service;
    private TeacherService $teacherService;

    public function __construct()
    {
        $this->service = new CourseService();
        $this->teacherService = new TeacherService();
    }

    public function index(): void
    {
        $courses = $this->service->getAllCourses();
        $this->render('course/list',[
            'title' => "List Courses",
            'courses' => $courses
        ]);
    }

    public function create(): void
    {
        $teachers = $this->teacherService->getAll();
        $this->render('course/create',[
            'title' => "Create New Course",
            'teachers' => $teachers,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'teacher_id' => 'required'
        ]);

        try {
            $this->service->store($validated);
            $_SESSION['success'] = "Created Course Success!";
        } catch (\Throwable $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        Router::redirect('course.show');
    }

    public function destroy(int $id)
    {
        try {
            $deleted = $this->service->deleteCourse($id);
            $_SESSION['success'] = "Course deleted successfully";
        } catch (\Throwable $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        Router::redirect('course.show');
    }

    public function edit(int $id): void
    {
        $course = $this->service->findCourseById($id);
        if (!$course) {
            $_SESSION['error'] = "Course not exist !!! ";
            Router::redirect('course.show');
        }
        $this->render('course/edit', [
            'title' => "edit course",
            'course' => $course,
            'teachers' => $this->teacherService->getAll(),
        ]);
    }

    public function update(Request $request): void
    {
    
        $validated = $request->validate([
            'id' => 'required',
            'title'  => "required|unique:courses,title,{$request->input('id')}",
            'teacher_id' => "required"
        ]);

        try {
            // HKT::dd($validated);
            $this->service->update($validated);
            $_SESSION['success'] = "Cập nhật giáo viên thành công!";
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        Router::redirect('course.show');
    }
}
