<?php

namespace App\Repository;

use App\Model\User;
use App\Util\HKT;

class UserRepository
{
    private User $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function findByEmail(string $email)
    {
        return $this->model->where('email','=',$email)->first(); // array
    }
}
