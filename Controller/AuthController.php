<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Router;
use App\Service\UserService;

class AuthController extends Controller
{
    private UserService $service;
    public function __construct()
    {
        $this->service = new UserService();
    }
    public function showLoginForm()
    {
        $this->authRender('auth/login');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if ($this->service->authenticate($email, $password)) {
            Router::redirect('student.show');
        } else {
            $_SESSION['error'] = "Invalid credentials!";
            Router::redirect('login');
        }
    }
    public function logout()
    {
        $this->service->logout();
        Router::redirect('login');
    }
}
