<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Database\Database;
use App\Models\Webinar;
use App\Models\Registration;

// بارگذاری env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
    $db = new Database();
    $pdo = $db->getConnection();

    echo "✅ اتصال به دیتابیس موفق بود!<br>";

    // تست یک کوئری ساده
    $stmt = $pdo->query("SELECT NOW() as current_time");
    $row = $stmt->fetch();
    echo "⏰ زمان فعلی دیتابیس: " . $row['current_time'];

} catch (Exception $e) {
    echo "❌ خطا: " . $e->getMessage();
    
}


