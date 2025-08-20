<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Models\Webinar;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$webinarModel = new Webinar();
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $desc  = trim($_POST['description']);
    $date  = $_POST['date'];
    $cap   = (int)$_POST['capacity'];

    if (!$title) $errors[] = "عنوان لازم است";
    if (!$desc) $errors[] = "توضیحات لازم است";
    if (!$date) $errors[] = "تاریخ لازم است";
    if ($cap < 1) $errors[] = "ظرفیت باید بزرگتر از صفر باشد";

    if (empty($errors)) {
        $webinarModel->create($title, $desc, $date, $cap);
        $success = "وبینار با موفقیت ایجاد شد!";
    }
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ایجاد وبینار</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">

<div class="container">
    <h1 class="mb-4">ایجاد وبینار جدید</h1>

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
            <label>عنوان وبینار</label>
            <input type="text" name="title" class="form-control" value="<?= $_POST['title'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label>توضیحات</label>
            <textarea name="description" class="form-control"><?= $_POST['description'] ?? '' ?></textarea>
        </div>
        <div class="mb-3">
            <label>تاریخ</label>
            <input type="datetime-local" name="date" class="form-control" value="<?= $_POST['date'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label>ظرفیت</label>
            <input type="number" name="capacity" class="form-control" value="<?= $_POST['capacity'] ?? 10 ?>">
        </div>
        <button class="btn btn-primary">ثبت وبینار</button>
        <a href="dashboard.php" class="btn btn-secondary">بازگشت</a>
    </form>
</div>

</body>
</html>
