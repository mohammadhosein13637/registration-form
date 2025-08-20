<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Models\Course;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$courseModel = new Course();
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $date = $_POST['date'];
    $capacity = (int)$_POST['capacity'];

    // ولیدیشن ساده
    if (!$title) $errors[] = "عنوان لازم است";
    if (!$description) $errors[] = "توضیحات لازم است";
    if (!$date) $errors[] = "تاریخ لازم است";
    if ($capacity < 1) $errors[] = "ظرفیت باید بزرگتر از صفر باشد";

    if (empty($errors)) {
        $courseModel->create($title, $description, $date, $capacity);
        $success = "دوره با موفقیت ایجاد شد!";
        // خالی کردن فرم
        $title = $description = '';
        $date = '';
        $capacity = '';
    }
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ایجاد دوره جدید</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">

<div class="container">
    <h1 class="mb-4">ایجاد دوره جدید</h1>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= $err ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label>عنوان دوره</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($title ?? '') ?>">
        </div>
        <div class="mb-3">
            <label>توضیحات</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($description ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label>تاریخ</label>
            <input type="datetime-local" name="date" class="form-control" value="<?= $date ?? '' ?>">
        </div>
        <div class="mb-3">
            <label>ظرفیت</label>
            <input type="number" name="capacity" class="form-control" value="<?= $capacity ?? '' ?>">
        </div>
        <button class="btn btn-primary">ایجاد دوره</button>
        <a href="dashboard.php" class="btn btn-secondary">بازگشت</a>
    </form>
</div>

</body>
</html>
