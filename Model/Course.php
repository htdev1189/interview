<?php
namespace App\Model;

class Course {
    public $id;
    public $title;
    public $description;
    public $teacher_id;
    public $created_at;

    public function __construct($id, $title, $description, $teacher_id, $created_at = null) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->teacher_id = $teacher_id;
        $this->created_at = $created_at ?? date("Y-m-d H:i:s");
    }
}
