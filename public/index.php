<?php

use Core\CSRF;

ini_set('log_errors', '1');
ini_set('error_log', '../log/php-error.log');
error_reporting(E_ALL);
ini_set('display_errors', '1');
error_log("✅");

require_once '../app/init.php';
require_once '../routes/web.php';

CSRF::validateOrRedirect();

Route::dispatch();
