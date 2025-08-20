<?php
namespace App\Models;

use App\Database\Database;
use PDO;

class Registration
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->getConnection();
    }

    // گرفتن همه ثبت‌نام‌ها (یا برای یک وبینار خاص)
    public function getAll($webinarId = null, $email = null)
{
    $sql = "SELECT r.*, w.title AS webinar_title, c.title AS course_title
            FROM registrations r
            LEFT JOIN webinars w ON r.webinar_id = w.id
            LEFT JOIN courses c ON r.course_id = c.id
            WHERE 1";

    $params = [];

    if ($webinarId) {
        $sql .= " AND (r.webinar_id = ? OR r.course_id = ?)";
        $params[] = $webinarId;
        $params[] = $webinarId;
    }

    if ($email) {
        $sql .= " AND r.email LIKE ?";
        $params[] = "%$email%";
    }

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll();
}


    // اضافه کردن ثبت‌نام جدید
    public function create($webinarId, $name, $email, $phone = null)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO registrations (webinar_id, name, email, phone) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$webinarId, $name, $email, $phone]);
    }

    // حذف ثبت‌نام
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM registrations WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
