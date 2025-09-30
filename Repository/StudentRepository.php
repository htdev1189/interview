<?php
namespace App\Repository;
use App\Connect\MySQLConnection;
use App\Model\Student;

class StudentRepository{
    private $connection;
    public function __construct()
    {
        $this->connection = MySQLConnection::getInstance()->connect();
    }

    // find all students
    public function findAll(){
        $sql = "select * from students";
        $result = $this->connection->query($sql);
        $students = [];
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
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
    public function findById($id){
        $sql = "select * from students where id = $id";
        $result = $this->connection->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            return new Student(
                $row['id'],
                $row['name'],
                $row['email'],
                $row['phone'],
                $row['created_at']
            );
        }
        return null;
    }

    // insert student
    public function create($students){
        $sql = "insert into students (name, email, phone) values (?,?,?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sss", $students->name, $students->email, $students->phone);
        return $stmt->execute();
    }

    // update student
    public function update($student){
        $sql = "update students set name = ?, email = ?, phone = ? where id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sssi", $student->name, $student->email, $student->phone, $student->id);
        return $stmt->execute();
    }
    // delete student
    public function delete($id){
        $sql = "delete from students where id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}