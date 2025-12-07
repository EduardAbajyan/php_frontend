<?php

function base_url($path = ''): string
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $path = trim($path, '/');
    $base = "{$protocol}://{$host}/{$path}";
    return $base;
}

function uploads_url($file = ''): string
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $file = ltrim($file, '/');
    $base = "{$protocol}://{$host}/uploads" . ($file ? "/{$file}" : '');
    return $base;
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
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $path = ltrim($path, '/');
    return "{$protocol}://{$host}/{$path}";
}

function url($routeName, $params = []): string
{
    // This is a simplified version - expand based on your routing needs
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
    ];
    
    $path = $routes[$routeName] ?? $routeName;
    return base_url($path);
}
