<?php

class AuthMidlewares
{
    public static function isAuthenticated()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    public static function requireAuth()
    {
        if (!self::isAuthenticated()) {
            header('Location: ' . base_url('login'));
            exit;
        }
    }

    public static function isAdmin()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    public static function requireAdmin()
    {
        if (!self::isAdmin()) {
            header('Location: ' . base_url('login'));
            exit;
        }
    }
}