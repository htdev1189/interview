<?php 
declare(strict_types=1);
session_start();
require_once __DIR__ . "/vendor/autoload.php";

// util
use App\Util\HKT;

// route
use App\Core\Router;
class_alias(Router::class, 'Router');



// .env
use Dotenv\Dotenv;
$envRoot = dirname(__DIR__);
if (file_exists($envRoot . '/.env')) {
    Dotenv::createImmutable($envRoot)->load();
}

// route/web.php
require_once __DIR__ . "/Route/web.php";

