<?php

spl_autoload_register(function($className){
    // Handle namespaced classes (e.g., Core\CSRF -> core/CSRF.php)
    $namespacedFile = dirname(__DIR__) . '/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($namespacedFile)) {
        require_once $namespacedFile;
        return;
    }

    // Handle non-namespaced classes
    $paths = [
        dirname(__DIR__) . '/app/middlewares/',
        dirname(__DIR__) . '/app/models/',
        dirname(__DIR__) . '/app/controllers/',
        dirname(__DIR__) . '/core/',
    ];
    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

?>