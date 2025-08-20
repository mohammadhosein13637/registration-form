<?php
namespace App\Models;

use App\Database\Database;
use PDO;

class Admin
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = (new Database())->getConnection();
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(string $email, string $password): bool
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO admins (email, password_hash) VALUES (?, ?)");
        return $stmt->execute([$email, $hash]);
    }
}
