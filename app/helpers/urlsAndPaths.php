<?php

function request_scheme(): string
{
    if (
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (string)$_SERVER['SERVER_PORT'] === '443')
        || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
    ) {
        return 'https';
    }

    return 'http';
}

function base_url($path = ''): string
{
    $protocol = request_scheme();
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $path = trim($path, '/');

    return $path === ''
        ? "{$protocol}://{$host}"
        : "{$protocol}://{$host}/{$path}";
}

function uploads_url($file = ''): string
{
    $protocol = request_scheme();
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $file = ltrim($file, '/');

    return "{$protocol}://{$host}/uploads" . ($file ? "/{$file}" : '');
}

function base_path($path = '', $dirToPathStart = ''): string
{
    return rtrim(APP_ROOT . '/' . ($dirToPathStart ? trim($dirToPathStart, '/') . '/' : '') . trim($path . '.php', '/'), '/');
}

function uploads_path($file = ''): string
{
    return APP_ROOT . DIRECTORY_SEPARATOR . 'public/uploads' . ($file ? DIRECTORY_SEPARATOR . ltrim($file, '/\\') : '');
}

function asset($path = ''): string
{
    $path = ltrim($path, '/');

    if (strpos($path, 'asset/') !== 0) {
        $path = 'asset/' . $path;
    }

    return base_url($path);
}

function url($routeName, $params = []): string
{
    $routes = [
        'home' => '',
        'contact' => 'contact',
        'contact.submit' => 'contact',
        'page1' => 'page1',
        'page2' => 'page2',
        'page3' => 'page3',
        'page4' => 'page4',
        'page5' => 'page5',
        'page6' => 'page6',
        'page7' => 'page7',
    ];

    $path = $routes[$routeName] ?? $routeName;
    return base_url($path);
}
