<?php 
declare(strict_types=1);

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once __DIR__ . "/vendor/autoload.php";

// util
use App\Util\HKT;



// .env
use Dotenv\Dotenv;
$envRoot = dirname(__DIR__);
if (file_exists($envRoot . '/.env')) {
    Dotenv::createImmutable($envRoot)->load();
}

// route/web.php
require_once __DIR__ . "/Route/web.php";

