<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
use App\Models\Registration;
use App\Models\Webinar;
use App\Models\Course;
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$registrationModel = new Registration();
// مدل ثبت‌نام

// مدل وبینار و دوره
$webinarModel = new Webinar();
$courseModel = new Course();

$webinars = $webinarModel->getAll();
$courses = $courseModel->getAll();

$errors = [];
$success = '';

// محدودیت: حداقل 30 ثانیه بین ثبت‌نام‌ها
$rateLimitSeconds = 30;

// دریافت IP کاربر
$ip = $_SERVER['REMOTE_ADDR'];

// زمان آخرین ثبت‌نام برای IP و Session
$now = time();
$lastSession = $_SESSION['last_registration_time'] ?? 0;
$lastIP = $_SESSION['ip_last_registration'][$ip] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (($now - $lastSession) < $rateLimitSeconds || ($now - $lastIP) < $rateLimitSeconds) {
        $errors[] = "لطفاً قبل از ثبت‌نام بعدی کمی صبر کنید (حداقل {$rateLimitSeconds} ثانیه).";
    } else {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $webinarId = $_POST['webinar_id'] ?? null;

        // ولیدیشن ساده
        if (!$name)
            $errors[] = "نام لازم است.";
        if (!$email)
            $errors[] = "ایمیل لازم است.";
        if (!$webinarId)
            $errors[] = "وبینار یا دوره انتخاب نشده است.";

        if (empty($errors)) {
            // ثبت در دیتابیس
            $registrationModel->create($webinarId, $name, $email, $phone);

            $success = "ثبت‌نام شما با موفقیت انجام شد!";

            // بروزرسانی زمان آخرین ثبت‌نام
            $_SESSION['last_registration_time'] = $now;
            $_SESSION['ip_last_registration'][$ip] = $now;

            // خالی کردن فرم
            $name = $email = $phone = '';
            $webinarId = '';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <title>ثبت‌نام وبینار</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4 bg-light">

    <div class="container">
        <h1 class="mb-4">ثبت‌نام وبینار / دوره</h1>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <?php if ($errors): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" class="row g-3">
            <div class="col-md-6">
                <label>نام</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label>ایمیل</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label>تلفن (اختیاری)</label>
                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($phone ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label>انتخاب وبینار / دوره</label>
                <select name="webinar_id" class="form-select">
                    <option value="">انتخاب کنید</option>
                    <?php
                    // فرض: $webinars و $courses از قبل از مدل گرفته شده‌اند
                    foreach ($webinars as $w):
                        ?>
                        <option value="<?= $w['id'] ?>" <?= ($webinarId == $w['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($w['title']) ?>
                        </option>
                    <?php endforeach; ?>
                    <?php foreach ($courses as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= ($webinarId == $c['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['title']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-12">
                <button class="btn btn-primary">ثبت‌نام</button>
            </div>
        </form>
    </div>

</body>

</html>