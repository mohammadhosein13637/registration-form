<?php
// public/index.php

require_once __DIR__ . '/../src/config/bootstrap.php'; // مسیر اصلاح شد
use App\Models\Webinar;
use App\Security\Csrf;

// گرفتن همه وبینارهای فعال و باز برای ثبت‌نام
$webinars = (new Webinar())->getActiveOpen();

// وضعیت موفقیت ثبت‌نام (در صورت ارسال از register.php)
$success = isset($_GET['success']) ? (int)$_GET['success'] : 0;
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8">
  <title>ثبت‌نام وبینارها</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CDN Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 m-0">وبینارهای فعال</h1>
    <a class="btn btn-outline-dark btn-sm" href="/admin/login.php">ورود ادمین</a>
  </div>

  <?php if ($success === 1): ?>
    <div class="alert alert-success">ثبت‌نام با موفقیت انجام شد!</div>
  <?php elseif ($success === 2): ?>
    <div class="alert alert-danger">خطا در ثبت‌نام. دوباره تلاش کنید.</div>
  <?php endif; ?>

  <?php if (empty($webinars)): ?>
    <div class="alert alert-info">فعلاً وبینار فعالی برای ثبت‌نام موجود نیست.</div>
  <?php else: ?>
    <div class="row g-3">
      <?php foreach ($webinars as $w): ?>
        <div class="col-12 col-md-6 col-lg-4">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($w['title']) ?></h5>
              <p class="card-text small text-muted mb-1"><?= htmlspecialchars($w['description'] ?? '') ?></p>
              <div class="small">
                تاریخ: <?= htmlspecialchars($w['date']) ?><br>
                ظرفیت: <?= (int)$w['capacity'] ?> /
                ثبت‌شده: <?= (int)$w['registered_count'] ?>
              </div>
            </div>
            <div class="card-footer bg-white">
              <form method="post" action="<?= BASE_URL ?>register.php" class="vstack gap-2">
                <?= Csrf::field() ?>
                <input type="hidden" name="webinar_id" value="<?= (int)$w['id'] ?>">
                <input class="form-control" name="name" placeholder="نام و نام خانوادگی" required>
                <input class="form-control" name="email" type="email" placeholder="ایمیل" required>
                <input class="form-control" name="phone" placeholder="شماره تماس (اختیاری)">
                <button class="btn btn-primary w-100">ثبت‌نام</button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</div>
</body>
</html>
