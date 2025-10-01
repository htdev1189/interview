<?php
// su ly liên quan đến dữ liệu request từ user (GET, POST, PUT, DELETE).
declare(strict_types=1);

namespace App\Http\Request;

use App\Model\Student;

class StudentRequest
{
    public static function fromPost(array $data): Student
    {
        // Validate dữ liệu
        if (empty($data['name'])) {
            throw new \InvalidArgumentException("Tên không được để trống");
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Email không hợp lệ");
        }

        return new Student(
            $data['id'] ?? null,
            $data['name'],
            $data['email'],
            $data['phone'] ?? null,
            null
        );
    }
}
