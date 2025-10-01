<?php

namespace App\Repository;

use App\Connect\MySQLConnection;
use App\Model\Course;
use App\Model\Student;

class StudentRepository
{
    private $connection;
    public function __construct()
    {
        $this->connection = MySQLConnection::getInstance()->connect();
    }

    // find all students
    public function findAll()
    {
        $sql = "select * from students";
        $result = $this->connection->query($sql);
        $students = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $students[] = new Student(
                    $row['id'],
                    $row['name'],
                    $row['email'],
                    $row['phone'],
                    $row['created_at']
                );
            }
        }
        return $students;
    }

    // find student by id
    public function findById($id)
    {
        $sql = "select * from students where id = ? ";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // get result
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        if (!$row) {
            return null; // ✅ trả null nếu không tìm thấy
        }

        return new Student(
            $row['id'],
            $row['name'],
            $row['email'],
            $row['phone'],
            $row['created_at']
        );
    }

    // insert student
    public function create($students)
    {
        $sql = "insert into students (name, email, phone) values (?,?,?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sss", $students->name, $students->email, $students->phone);
        return $stmt->execute();
    }

    // update student
    public function update($student)
    {
        $sql = "update students set name = ?, email = ?, phone = ? where id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sssi", $student->name, $student->email, $student->phone, $student->id);
        return $stmt->execute();
    }
    // delete student
    public function delete($id)
    {
        $sql = "delete from students where id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function registerCourse($studentId, $courseId)
    {
        // kiểm tra đã đăng ký chưa
        $stmt = $this->connection->prepare("SELECT * FROM student_course WHERE student_id = ? AND course_id = ?");
        $stmt->execute([$studentId, $courseId]);

        if ($stmt->fetch()) {
            return false; // đã tồn tại
        }

        // thêm mới
        $stmt = $this->connection->prepare("INSERT INTO student_course (student_id, course_id) VALUES (?, ?)");
        return $stmt->execute([$studentId, $courseId]);
    }

    // lay thong tin khoa hoc theo id student
    public function findWithCourses($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$id]);
        // $row = $stmt->fetch(); // $row bây giờ chỉ là true/false
        $result = $stmt->get_result();   // ✅ lấy dữ liệu
        $row = $result->fetch_assoc();   // ✅ lấy 1 dòng
        $student = new Student($row['id'], $row['name'], $row['email'], $row['phone'], $row['created_at']);
        $stmt->close();   // 🔥 Quan trọng: giải phóng trước khi chạy query khác

        // thiet lap courses
        $sql1 = "SELECT c.* FROM courses c
            JOIN student_course sc ON sc.course_id = c.id
            WHERE sc.student_id = ?";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("i", $id);
        $stmt1->execute([$id]);

        $result1 = $stmt1->get_result();
        while ($crow = $result1->fetch_assoc()) {

            $couser = new Course($crow['id'], $crow['title'], $crow['description'], $crow['teacher_id'], $crow['created_at']);
            $student->courses[] = $couser;
        }
        $stmt1->close();

        return $student;
    }
}
