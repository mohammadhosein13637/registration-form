<?php
namespace App\Models;
use App\Database\Database;
use PDO;

class Course
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->getConnection();
    }

    // گرفتن همه دوره‌ها
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM courses ORDER BY date DESC");
        return $stmt->fetchAll();
    }

    // گرفتن یک دوره با id
    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // اضافه کردن دوره جدید
    public function create($title, $description, $date, $capacity)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO courses (title, description, date, capacity) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$title, $description, $date, $capacity]);
    }



    // حذف دوره
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM courses WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ویرایش دوره
    public function update($id, $title, $description, $date, $capacity)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE courses SET title=?, description=?, date=?, capacity=? WHERE id=?"
        );
        return $stmt->execute([$title, $description, $date, $capacity, $id]);
    }
}
