<?php

namespace App\Model;

use App\Core\Model;

class User extends Model
{
    protected string $table = 'users';
    protected array $fillable = ['name', 'email', 'password', 'role'];
}
