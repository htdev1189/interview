<?php
namespace App\Core;

class AuthMiddleware
{
    public function handle()
    {
        if (empty($_SESSION['user'])) {
            $_SESSION['error'] = "Please login first!";
            Router::redirect('/login');
            exit;
        }
    }
}
