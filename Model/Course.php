<?php

declare(strict_types=1);

namespace App\Model;

use App\Core\Model;

class Course extends Model
{
    protected string $table = 'courses';
    protected array $fillable = ['title', 'description', 'teacher_id', 'status'];
}
