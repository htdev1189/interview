<?php

namespace App\Repository;

use App\Model\Teacher;
use App\Connect\MySQLConnection;
use App\Util\HKT;

class TeacherRepository
{
    private Teacher $model;
    public function __construct()
    {
        $this->model = new Teacher();
    }

    // get all
    public function getAll(){
        try {
            return $this->model->where('status', '=', 1)->get();
        } catch (\Exception $e) {
            throw new \RuntimeException("Lỗi khi lấy danh sách sinh viên: " . $e->getMessage());
        }
    }


    // create
    public function create($data){
        try {
            return $this->model->create($data);
        } catch (\Exception $e) {
            throw new \RuntimeException("Lỗi khi thêm giáo viên: " . $e->getMessage());
        }
    }
    // private $connection;

    // public function __construct()
    // {
    //     $this->connection = MySQLConnection::getInstance()->connect();
    // }

    // public function getAll()
    // {
    //     $result = $this->connection->query("SELECT * FROM teachers where status = 1");
    //     $teachers = [];
    //     while ($row = $result->fetch_assoc()) {
    //         $teachers[] = new Teacher($row['id'], $row['name'], $row['email'], $row['phone'], $row['status'], $row['created_at']);
    //     }
    //     return $teachers;
    // }

    // public function create(Teacher $teacher)
    // {
    //     $sql = "INSERT INTO teachers (name, email, phone, created_at) VALUES (?, ?, ?, ?)";
    //     $stmt = $this->connection->prepare($sql);
    //     $stmt->bind_param("ssss", $teacher->name, $teacher->email, $teacher->phone, $teacher->created_at);
    //     return $stmt->execute();
    // }

    // public function update(Teacher $teacher)
    // {
    //     $sql = "UPDATE teachers SET name=?, email=?, phone=? WHERE id=?";
    //     $stmt = $this->connection->prepare($sql);
    //     $stmt->bind_param("sssi", $teacher->name, $teacher->email, $teacher->phone, $teacher->id);
    //     $stmt->execute();
    //     // Nếu $teacher->id không tồn tại trong DB, vẫn trả về true (nhưng không update bản ghi nào).
    //     // Nên check affected_rows
    //     if ($stmt->affected_rows === 0) {
    //         throw new \Exception("No teacher found with ID {$teacher->id}");
    //     }
    //     return true;
    // }

    // public function delete($id)
    // {
    //     $sql = "UPDATE teachers set status = 0 WHERE id=?";
    //     $stmt = $this->connection->prepare($sql);
    //     $stmt->bind_param("i", $id);
    //     $stmt->execute();
    //     return $stmt->affected_rows > 0; // chỉ true nếu có ít nhất 1 bản ghi bị update
    // }
    // // get by id
    // public function getById($id)
    // {
    //     $sql = "SELECT * FROM teachers WHERE id = ?";
    //     $stmt = $this->connection->prepare($sql);
    //     $stmt->bind_param("i", $id);
    //     $stmt->execute();

    //     $result = $stmt->get_result();
    //     if ($row = $result->fetch_assoc()) {
    //         return new Teacher(
    //             $row['id'],
    //             $row['name'],
    //             $row['email'],
    //             $row['phone'],
    //             $row['status'],
    //             $row['created_at']
    //         );
    //     }

    //     return null; // không tìm thấy
    // }
}
