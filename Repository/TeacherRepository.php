<?php

namespace App\Repository;

use App\Model\Teacher;
use App\Connect\MySQLConnection;

class TeacherRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = MySQLConnection::getInstance()->connect();
    }

    public function getAll()
    {
        $result = $this->connection->query("SELECT * FROM teachers");
        $teachers = [];
        while ($row = $result->fetch_assoc()) {
            $teachers[] = new Teacher($row['id'], $row['name'], $row['email'], $row['phone'], $row['created_at']);
        }
        return $teachers;
    }

    public function create(Teacher $teacher)
    {
        $sql = "INSERT INTO teachers (name, email, phone, created_at) VALUES (?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssss", $teacher->name, $teacher->email, $teacher->phone, $teacher->created_at);
        return $stmt->execute();
    }

    public function update(Teacher $teacher)
    {
        $sql = "UPDATE teachers SET name=?, email=?, phone=? WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sssi", $teacher->name, $teacher->email, $teacher->phone, $teacher->id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM teachers WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    // get by id
    public function getById($id)
    {
        $sql = "SELECT * FROM teachers WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return new Teacher(
                $row['id'],
                $row['name'],
                $row['email'],
                $row['phone'],
                $row['created_at']
            );
        }

        return null; // không tìm thấy
    }
}
