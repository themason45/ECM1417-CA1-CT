<?php


use JetBrains\PhpStorm\Pure;

class Csrf
{
    static function generateToken(): string
    {
        try {
            return bin2hex(random_bytes(32));
        } catch (Exception $e) {
            echo $e;
        }
        return "";
    }

    static function formInput(): string
    {
        $token = $_SESSION["token"];
        return '<input type="text" name="token" value="'. $token .'" hidden>';
    }

    #[Pure] static function verifyToken($token): bool
    {
        return hash_equals($_SESSION['token'], $token);
    }
}