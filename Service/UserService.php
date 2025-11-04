<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Util\HKT;

class UserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function authenticate(string $email, string $password): bool
    {
        $user = $this->userRepository->findByEmail($email);
        if (!$user) return false;
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'role' => $user['role']
            ];
            return true;
        }
        return false;
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
    }

    public function currentUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }
}
