<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Database\Database;
use App\Models\Webinar;
use App\Models\Registration;

function h($label) { echo "\n=== $label ===\n"; }
function ok($msg) { echo "[OK] $msg\n"; }
function fail($msg) { echo "[FAIL] $msg\n"; exit(1); }

try {
    $pdo = (new Database())->getConnection();
    $dbName = $pdo->query("SELECT DATABASE()")->fetchColumn();
    h("DB");
    ok("Connected to '$dbName'");
} catch (Throwable $e) {
    fail("DB connection error: ".$e->getMessage());
}

$wModel = new Webinar();
$rModel = new Registration();

// اطمینان از وجود حداقل یک وبینار
h("Webinar setup");
$rows = $wModel->getAll();
if (count($rows) === 0) {
   $title = 'TEST_' . date('Ymd_His');
   $desc  = 'Smoke test webinar';
   $date  = date('Y-m-d', strtotime('+3 days')); // با نوع DATE سازگاره
   $cap   = 30;

   // مستقیم با PDO وارد می‌کنیم تا وابسته به تغییر مدل نشیم
   $ins = $pdo->prepare("INSERT INTO webinars (title, description, date, capacity) VALUES (?, ?, ?, ?)");
   if (!$ins->execute([$title, $desc, $date, $cap])) {
       fail("Cannot insert test webinar");
   }
   $wid = (int)$pdo->lastInsertId();
   ok("Inserted test webinar id=$wid");
} else {
   $wid = (int)$rows[0]['id']; // از آخرین/اولین موجود استفاده می‌کنیم
   ok("Using existing webinar id=$wid");
}

// تست گرفتن لیست وبینارها
h("Webinar::getAll()");
$all = $wModel->getAll();
if (is_array($all)) ok("Fetched ".count($all)." webinar(s)");
else fail("getAll returned non-array");

// تست ثبت‌نام
h("Registration::create()");
$name  = 'Smoke Test';
$email = 'smoke+'.time().'@example.com';
$phone = '09'.rand(100000000, 999999999);
if ($rModel->create($wid, $name, $email, $phone)) {
    ok("Registration created for webinar $wid");
} else {
    fail("Registration create failed");
}

// تست گرفتن ثبت‌نام‌های همان وبینار
h("Registration::getAll()");
$regs = $rModel->getAll($wid);
if (is_array($regs)) ok("Fetched ".count($regs)." registration(s) for webinar $wid");
else fail("getAll(\$webinarId) returned non-array");

echo "\nAll smoke tests passed ✅\n";
