<?php

session_start();

define('APP_ROOT', dirname(__DIR__));

// Load environment variables and path and url functions
require_once APP_ROOT . '/app/helpers/urlsAndPaths.php';
require_once APP_ROOT . '/app/helpers/env.php';
loadEnv(APP_ROOT . '/.env');

// Load configuration files
require_once APP_ROOT . '/config/config.php';
require_once APP_ROOT . '/config/database.php';
require_once APP_ROOT . '/vendor/autoload.php';
require_once APP_ROOT . '/app/helpers/CSRF_helper.php';
require_once APP_ROOT . '/app/helpers/rendering.php';

if (session_status() === PHP_SESSION_NONE) session_start();