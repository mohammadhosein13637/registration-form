<?php
require_once __DIR__ . '/../../config/bootstrap.php';
use App\Services\Auth;

Auth::logout();
header('Location: /admin/login.php');
exit;
