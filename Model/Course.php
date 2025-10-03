<?php
namespace App\Model;

use App\Util\HKT;

class Course {
    public $id;
    public $title;
    public $slug;
    public $description;
    public $teacher_id;
    public $created_at;
    public $status;

    public $students = []; // danh sách Student object

    public function __construct($id, $title, $description, $teacher_id, $created_at = null, $status = 1) {
        $this->id = $id;
        $this->title = $title;
        $this->slug = HKT::slugify($title);
        $this->description = $description;
        $this->teacher_id = $teacher_id;
        // $this->created_at = $created_at ?? date("Y-m-d H:i:s");
        $this->created_at = $created_at;
        $this->status = $status;
    }
}
