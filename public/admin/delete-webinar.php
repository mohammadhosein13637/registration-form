<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Models\Webinar;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$webinarModel = new Webinar();

$id = $_GET['id'] ?? null;
if (!$id) {
    die("شناسه وبینار مشخص نشده!");
}

// حذف وبینار
$webinarModel->delete($id);

// ریدایرکت به داشبورد
header("Location: dashboard.php?deleted=1");
exit;
