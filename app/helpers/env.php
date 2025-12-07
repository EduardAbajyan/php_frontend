<?php

/**
 * Load environment variables from .env file
 */
function loadEnv($path = __DIR__ . '/../../.env')
{
    if (!file_exists($path)) {
        throw new Exception('.env file not found at: ' . $path);
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Parse KEY=VALUE
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            
            // Remove quotes if present
            $value = trim($value, '"\'');
            
            // Set environment variable
            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }
    }
}

/**
 * Get environment variable with optional default value
 */
function env($key, $default = null)
{
    $value = $_ENV[$key] ?? getenv($key);
    
    if ($value === false) {
        return $default;
    }
    
    return $value;
}

?>
