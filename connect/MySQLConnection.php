<?php
declare(strict_types=1);
namespace App\Connect;
use App\Connect\DBConnectionInterface;
use Dotenv\Dotenv;

class MySQLConnection implements DBConnectionInterface
{
    // bien luu tru instance duy nhat
    private static $instance;

    private $connection;


    private function __construct()
    {
        // Load biến môi trường từ file .env
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../"); 
        $dotenv->load();

        $host = $_ENV["DB_HOST"];
        $user = $_ENV["DB_USERNAME"];
        $password = $_ENV["DB_PASSWORD"];
        $database = $_ENV["DB_DATABASE"];

        $this->connection = new \mysqli($host, $user, $password, $database);

        if ($this->connection->connect_error) {
            die("Kết nối thất bại: " . $this->connection->connect_error);
        }
    }

    // điểm truy cập toàn cục đến instance
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function connect()
    {
        return $this->connection;
    }
}