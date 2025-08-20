<?php
namespace App\Database;
use PDO;
use PDOException;
class Database
{
    private $pdo;
    public function __construct()
    {
        $host = $_ENV['DB_HOST'];
        $db = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];
        $charset = $_ENV['DB_CHARSET'];
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            
            $this->pdo = new PDO($dsn, $user, $pass, $options);
            $stmt = $this->pdo->query("SELECT DATABASE()");
            echo "Connected to DB: " . $stmt->fetchColumn();
        } catch (PDOException $e) {
            throw new \Exception("Database connection failed: " . $e->getMessage());
        }
    }
    public function getConnection()
    {
        return $this->pdo;
    }
}