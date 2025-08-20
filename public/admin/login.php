<?php
require_once __DIR__ . '/../../config/bootstrap.php';

use App\Security\Csrf;
use App\Services\Auth;

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::check($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid CSRF token';
    } else {
        $email = trim((string)($_POST['email'] ?? ''));
        $pass  = (string)($_POST['password'] ?? '');
        if ($email && $pass && Auth::attempt($email, $pass)) {
            header('Location: /admin/dashboard.php');
            exit;
        }
        $error = 'Invalid credentials';
    }
}
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8">
  <title>ورود ادمین</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5" style="max-width:420px">
  <h1 class="h4 mb-4 text-center">ورود ادمین</h1>
  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="post" class="vstack gap-3 card card-body">
    <?= Csrf::field() ?>
    <input class="form-control" type="email" name="email" placeholder="ایمیل" required>
    <input class="form-control" type="password" name="password" placeholder="رمز عبور" required>
    <button class="btn btn-dark w-100">ورود</button>
  </form>
  <div class="text-center mt-3">
    <a href="/">← بازگشت به سایت</a>
  </div>
</div>
</body>
</html>
