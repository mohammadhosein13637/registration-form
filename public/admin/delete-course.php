<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Models\Course;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$courseModel = new Course();

$id = $_GET['id'] ?? null;
if (!$id) {
    die("شناسه دوره مشخص نشده!");
}

// حذف دوره
$courseModel->delete($id);

// ریدایرکت به داشبورد
header("Location: dashboard.php?deleted=1");
exit;
