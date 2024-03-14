<?php
namespace Database;
use PDO;
class Database {
    private static $instance;
    private $pdo;

    private function __construct() {
        $this->pdo = $pdo;
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function connect() {
        $host = 'localhost';
        $dbname = 'prvi_zadatak';
        $username = 'prvi_zadatak';
        $password = 'zadatak';
        $dsn = "mysql:host=$host;dbname=$dbname";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        $this->pdo = new PDO($dsn, $username, $password, $options);
        return $this->pdo;
    }

    public function getPdo() {
        return $this->pdo;
    }
}
