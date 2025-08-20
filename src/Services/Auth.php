<?php
namespace App\Services;

use App\Models\Admin;

class Auth
{
    public static function attempt(string $email, string $password): bool
    {
        $admin = (new Admin())->findByEmail($email);
        if (!$admin) return false;
        if (!password_verify($password, $admin['password_hash'])) return false;

        $_SESSION['admin_id'] = (int)$admin['id'];
        $_SESSION['admin_email'] = $admin['email'];
        return true;
    }

    public static function check(): bool
    {
        return !empty($_SESSION['admin_id']);
    }

    public static function logout(): void
    {
        unset($_SESSION['admin_id'], $_SESSION['admin_email']);
        session_regenerate_id(true);
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: /admin/login.php');
            exit;
        }
    }
}
