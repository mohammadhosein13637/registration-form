<?php
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\Webinar;
use App\Models\Course;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$webinarModel = new Webinar();
$courseModel = new Course();

$webinars = $webinarModel->getAll();
$courses = $courseModel->getAll();
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>داشبورد ادمین</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">

<div class="container">
    <h1 class="mb-4">داشبورد ادمین</h1>

    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">وبینارها</h5>
                    <a href="create-webinar.php" class="btn btn-success btn-sm">وبینار جدید</a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>عنوان</th>
                            <th>تاریخ</th>
                            <th>ظرفیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($webinars as $w): ?>
                            <tr>
                                <td><?= $w['id'] ?></td>
                                <td><?= htmlspecialchars($w['title']) ?></td>
                                <td><?= $w['date'] ?></td>
                                <td><?= $w['capacity'] ?></td>
                                <td>
                                    <a href="edit-webinar.php?id=<?= $w['id'] ?>" class="btn btn-warning btn-sm">ویرایش</a>
                                    <a href="delete-webinar.php?id=<?= $w['id'] ?>" class="btn btn-danger btn-sm">حذف</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">دوره‌ها</h5>
                    <a href="create-course.php" class="btn btn-success btn-sm">دوره جدید</a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>عنوان</th>
                            <th>تاریخ</th>
                            <th>ظرفیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($courses as $c): ?>
                            <tr>
                                <td><?= $c['id'] ?></td>
                                <td><?= htmlspecialchars($c['title']) ?></td>
                                <td><?= $c['date'] ?></td>
                                <td><?= $c['capacity'] ?></td>
                                <td>
                                    <a href="edit-course.php?id=<?= $c['id'] ?>" class="btn btn-warning btn-sm">ویرایش</a>
                                    <a href="delete-course.php?id=<?= $c['id'] ?>" class="btn btn-danger btn-sm">حذف</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
<?php if(isset($_GET['deleted'])): ?>
    <div class="alert alert-success">وبینار با موفقیت حذف شد!</div>
<?php endif; ?>
