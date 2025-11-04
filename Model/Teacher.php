<?php

declare(strict_types=1);

namespace App\Model;

use App\Core\Model;

class Teacher extends Model
{
    protected string $table = 'teachers';
    protected array $fillable = ['name', 'email', 'phone', 'status'];
}
