<?php

namespace Core;

class CSRF
{
    protected const SESSION_KEY = '_csrf_tokens';
    protected const MAX_TOKENS = 25; // limit to avoid session bloat (tabs/forms)

    // Generate a new one-time token for a form.
    public static function generateToken(): string
    {
        Session::start();
        $tokens = Session::get(self::SESSION_KEY, []);

        // Prune oldest if exceeding limit
        if (count($tokens) >= self::MAX_TOKENS) {
            array_shift($tokens);
        }
        $token = bin2hex(random_bytes(32)); // 64-char hex
        $tokens[$token] = time(); // can store timestamp for later expiry if desired
        Session::set(self::SESSION_KEY, $tokens);

        return $token;
    }

    // Validate a token (returns bool). Does NOT redirect.
    public static function validateToken(?string $token): bool
    {
        if (empty($token)) {
            return false;
        }
        Session::start();
        $tokens = Session::get(self::SESSION_KEY, []);

        if (!isset($tokens[$token])) {
            return false;
        }
        // Token found → consume it (single-use)
        unset($tokens[$token]);
        Session::set(self::SESSION_KEY, $tokens);

        return true;
    }

    // Middleware-like: validate POST automatically; redirect back if invalid.
    public static function validateOrRedirect(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }
        $submitted = $_POST['csrf_token'] ?? null;

        if (!self::validateToken($submitted)) {
            // Set flash & redirect back
            Session::flash('error', 'Invalid security token. Please try again.');
            self::redirectBack();
            exit;
        }

        // (Optional) You could regenerate session id after sensitive POSTs here
        Session::regenerate();
    }

    // Try redirect back using REFERER or stored last GET route.
    protected static function redirectBack(): void
    {
        Session::start();
        $fallback = '/'; // fallback root
        $last = Session::get('_last_get_url', $fallback);

        $target = $_SERVER['HTTP_REFERER'] ?? $last ?? $fallback;
        header("Location: {$target}", true, 302);
    }
}
