<?php

namespace App\Core;
use App\Util\HKT;

abstract class Controller
{
    protected function render(string $view, array $params = [])
    {
        extract($params, EXTR_SKIP);
        ob_start();
        require __DIR__ . '/../Views/' . $view . '.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/layout/backend.php';
    }

    protected function authRender(string $view, array $params = [])
    {
        extract($params, EXTR_SKIP);
        ob_start();
        require __DIR__ . '/../Views/' . $view . '.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/layout/auth.php';
    }
}
