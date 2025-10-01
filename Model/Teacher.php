<?php 
namespace App\Model;

class Teacher {
    public $id;
    public $name;
    public $email;
    public $phone;
    public $created_at;
    public $courses = []; // danh sách Student object

    public function __construct($id, $name, $email, $phone, $created_at = null) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->created_at = $created_at ?? date("Y-m-d H:i:s");
    }
}
