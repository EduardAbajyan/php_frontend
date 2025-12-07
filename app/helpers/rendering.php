<?php

function redirect($path, $queryParams = []): void
{
    $url = base_url($path);
    if (!empty($queryParams)) {
        $url .= '?' . http_build_query($queryParams);
    }
    header("Location: {$url}");
    exit;
}

function render(string $view, array $data = [], $layout = 'layout'): void
{
    echo "<!-- Rendering view: " . base_path($view, 'app/views')  . " with layout: " . (base_path($layout, 'app/views/layouts') ?? base_path('app/views/layout.php')) . " -->" . PHP_EOL; // Debug line
    $viewFile   = realpath(base_path($view, 'app/views'));
    $layoutFile = realpath(base_path($layout, 'app/views/layouts') ?? base_path('app/views/home_layout.php'));

    if (!is_file($viewFile)) {
        throw new RuntimeException("View not found: {$viewFile}");
    }
    if (!is_file($layoutFile)) {
        throw new RuntimeException("Layout not found: {$layoutFile}");
    }

    extract($data, EXTR_SKIP);

    ob_start();
    require $viewFile;
    $location = $data['location'] ?? '';
    $content = ob_get_clean();

    ob_start();
    require $layoutFile;
    $final = ob_get_clean();

    echo $final;
    exit;
}
