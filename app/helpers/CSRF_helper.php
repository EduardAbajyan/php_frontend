<?php

use Core\CSRF;
use Core\Session;

function csrf_token(): string
{
    return CSRF::generateToken();
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

// Retrieve and consume a single flash message by key
function flash(string $key): ?string
{
    return Session::flash($key);
}

// Return HTML block of all flash messages (consumes them)
function flash_block(): string
{
    $messages = Session::allFlash();
    if (empty($messages)) {
        return '';
    }

    $html = '<div class="flash-messages">';
    foreach ($messages as $type => $text) {
        $bootstrapClass = match ($type) {
            'success' => 'alert-success',
            'error' => 'alert-danger',
            'warning' => 'alert-warning',
            'info' => 'alert-info',
            default => 'alert-info'
        };

        $html .= '<div class="alert ' . $bootstrapClass . ' alert-dismissible fade show" role="alert">' .
            htmlspecialchars($text) .
            '<button 
                onClick="this.parentElement.style.display=\'none\';"
            type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' .
            '</div>';
    }
    $html .= '</div>';

    return $html;
}
