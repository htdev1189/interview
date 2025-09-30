<?php

namespace App\Repository;

use App\Model\Course;
use App\Connect\MySQLConnection;

class CourseRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = MySQLConnection::getInstance()->connect();
    }

    public function getAll()
    {
        $sql = "Select * from courses where status = 1";
        $result = $this->connection->query($sql);
        $courses = [];
        while ($row = $result->fetch_assoc()) {
            $course = new Course($row['id'], $row['title'], $row['description'], $row['teacher_id'], $row['created_at']);
            $courses[] = $course;
        }
        return $courses;
    }

    public function create(Course $course)
    {
        $sql = "INSERT INTO courses (title, description, teacher_id) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssi", $course->title, $course->description, $course->teacher_id);
        return $stmt->execute();
    }

    public function update(Course $course)
    {
        $sql = "UPDATE courses SET title=?, description=?, teacher_id=? WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssii", $course->title, $course->description, $course->teacher_id, $course->id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        // $sql = "DELETE FROM courses WHERE id=?";
        $sql = "UPDATE courses set status = 0 where id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // find by id
    public function findById($id){
        $sql = "SELECT * FROM courses WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return new Course(
                $row['id'],
                $row['title'],
                $row['description'],
                $row['teacher_id'],
                $row['created_at']
            );
        }

        return null; // không tìm thấy
    }
}
