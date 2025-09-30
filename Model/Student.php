<?php 
declare(strict_types=1);
namespace App\Model;


class Student {
    public $id;
    public $name;
    public $email;
    public $phone;
    public $created_at;

    public function __construct($id, $name, $email, $phone, $created_at) {
         $this->id = $id;
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->created_at = $created_at;
    }

    
}