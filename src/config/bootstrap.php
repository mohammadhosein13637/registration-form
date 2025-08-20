<?php
// src/config/bootstrap.php

declare(strict_types=1);

// Composer autoload
require_once __DIR__ . '/../../vendor/autoload.php';

// تعریف BASE_URL پروژه
define('BASE_URL', '/registration-form/public/');

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Timezone (اختیاری)
date_default_timezone_set('UTC');

// Session (امن‌تر)
$secure   = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
$lifetime = 60 * 60 * 4; // 4 ساعت
session_set_cookie_params([
    'lifetime' => $lifetime,
    'path'     => '/',
    'domain'   => '',
    'secure'   => $secure,
    'httponly' => true,
    'samesite' => 'Strict',
]);
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
