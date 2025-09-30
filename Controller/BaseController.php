<?php
namespace App\Controller;

class BaseController
{
    protected function render(string $view, array $data = []) {
        extract($data);
        include __DIR__ . '/../view/' . $view . '.php';
    }
}