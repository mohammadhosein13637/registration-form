<?php
namespace App\Security;

class Csrf
{
    public static function token(): string
    {
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf'];
    }

    public static function field(): string
    {
        $t = self::token();
        return '<input type="hidden" name="csrf_token" value="'.$t.'">';
    }

    public static function check(?string $token): bool
    {
        return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], (string)$token);
    }
}
