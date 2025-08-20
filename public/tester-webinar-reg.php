<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Models\Webinar;
use App\Models\Registration;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
// تست وبینار
$webinar = new Webinar();
print_r($webinar->getAll());

// تست ثبت‌نام
$reg = new Registration();
print_r($reg->getAll());
