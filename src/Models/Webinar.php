<?php
namespace App\Models;

use App\Database\Database;
use PDO;

class Webinar
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = (new Database())->getConnection();
    }

    // فقط وبینارهای فعالِ باز برای ثبت‌نام
    public function getActiveOpen()
    {
        $sql = "
            SELECT w.*,
                   (SELECT COUNT(*) FROM registrations r WHERE r.webinar_id = w.id) AS registered_count
            FROM webinars w
            WHERE w.is_active = 1
              AND w.date >= CURDATE()
            ORDER BY w.date ASC
        ";
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll();

        // فیلتر طرفِ PHP: ظرفیت باقی‌مانده > 0
        return array_values(array_filter($rows, function($w) {
            return (int)$w['capacity'] > (int)$w['registered_count'];
        }));
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM webinars ORDER BY date DESC");
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM webinars WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($title, $description, $date, $capacity, $isActive = 1)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO webinars (title, description, date, capacity, is_active) VALUES (?, ?, ?, ?, ?)"
        );
        return $stmt->execute([$title, $description, $date, $capacity, $isActive]);
    }
    public function update($id, $title, $description, $date, $capacity) {
        $stmt = $this->pdo->prepare("UPDATE webinars SET title=?, description=?, date=?, capacity=? WHERE id=?");
        return $stmt->execute([$title, $description, $date, $capacity, $id]);
    }
    

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM webinars WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
