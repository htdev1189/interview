<?php

declare(strict_types=1);

namespace App\Model;

use App\Core\Model;

class Student extends Model
{
    protected string $table = 'students';
    protected array $fillable = ['name', 'email', 'phone', 'status'];
}
