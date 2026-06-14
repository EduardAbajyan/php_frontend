<?php

class Route
{
    protected static $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => []
    ];
    protected static $nameRoutes = [];
    protected static $lastAddedRoute = null;

    public static function get($uri, $controllerAction)
    {
        $cleanedUri = trim(preg_replace('/\.php$/', '', urldecode($uri)), '/');
        self::$routes['GET'][$cleanedUri] = $controllerAction;
        self::$lastAddedRoute = ['method' => 'GET', 'uri' => $cleanedUri, 'action' => $controllerAction];
        return new static;
    }

    public static function post($uri, $controllerAction)
    {
        $cleanedUri = trim(preg_replace('/\.php$/', '', urldecode($uri)), '/');
        self::$routes['POST'][$cleanedUri] = $controllerAction;
        self::$lastAddedRoute = ['method' => 'POST', 'uri' => $cleanedUri, 'action' => $controllerAction];
        return new static;
    }

    public static function put($uri, $controllerAction)
    {
        $cleanedUri = trim(preg_replace('/\.php$/', '', urldecode($uri)), '/');
        self::$routes['PUT'][$cleanedUri] = $controllerAction;
        self::$lastAddedRoute = ['method' => 'PUT', 'uri' => $cleanedUri, 'action' => $controllerAction];
        return new static;
    }

    public static function patch($uri, $controllerAction)
    {
        $cleanedUri = trim(preg_replace('/\.php$/', '', urldecode($uri)), '/');
        self::$routes['PATCH'][$cleanedUri] = $controllerAction;
        self::$lastAddedRoute = ['method' => 'PATCH', 'uri' => $cleanedUri, 'action' => $controllerAction];
        return new static;
    }

    public static function delete($uri, $controllerAction)
    {
        $cleanedUri = trim(preg_replace('/\.php$/', '', urldecode($uri)), '/');
        self::$routes['DELETE'][$cleanedUri] = $controllerAction;
        self::$lastAddedRoute = ['method' => 'DELETE', 'uri' => $cleanedUri, 'action' => $controllerAction];
        return new static;
    }

    public static function name($routerName)
    {
        if (self::$lastAddedRoute !== null) {
            self::$nameRoutes[$routerName] = self::$lastAddedRoute['uri'];
            self::$lastAddedRoute = null;
        } else throw new Exception("No route has been added to name.");
        return new static;
    }

    public static function route($routeName, $params = [])
    {
        $route = self::$nameRoutes[$routeName] ?? null;
        if (!$route) return null;
        $url = $route;
        foreach ($params as $key => $value) {
            $url = preg_replace('/\{' . $key . '=([^}]+)\}/', '{' . $key . '=' . $value . '}', $url);
        }
        return base_url($url);
    }

    protected static function match($method, $requestUrl)
    {
        $routesForMethod = self::$routes[$method] ?? [];
        foreach ($routesForMethod as $route => $controllerAction) {
            if (empty($controllerAction)) continue;
            $patternFromRoute = preg_replace('#\{[a-zA-Z0-9_]+\}#', '{([a-zA-Z0-9_]+)}', $route);
            if (preg_match('#^' . $patternFromRoute . '$#', $requestUrl, $matchesWithRequestedUrl)) {
                array_shift($matchesWithRequestedUrl);
                preg_match('#^' . $patternFromRoute . '$#', $route, $matchesFromRoute);
                array_shift($matchesFromRoute);
                $params = [];
                foreach ($matchesFromRoute as $index => $match) {
                    $paramName = trim($match, '{}');
                    $params[$paramName] = $matchesWithRequestedUrl[$index];
                }
                return [
                    'action' => $controllerAction,
                    'params' => $params
                ];
            }
        }
        return [
            'action' => null,
            'params' => []
        ];
    }

    protected static function invokeControllerMethod($controllerName, $methodName, $httpMethod, $data)
    {
        try {
            require_once APP_ROOT . '/app/controllers/' . $controllerName . '.php';
            $controllerInstance = new $controllerName();
        } catch (Exception $e) {
            http_response_code(500);
            echo "500 Internal Server Error: Controller '$controllerName' could not be loaded.";
            exit;
        }
        if (!method_exists($controllerInstance, $methodName)) {
            http_response_code(500);
            echo "500 Internal Server Error: Method '$methodName' not found in controller '$controllerName'.";
            exit;
        }
        call_user_func_array([$controllerInstance, $methodName], [$httpMethod, $data]);
    }

    protected static function tryServePublicAsset($cleanedUrl, $method)
    {
        if (!in_array($method, ['GET', 'HEAD'])) {
            return false;
        }

        $relativePath = ltrim($cleanedUrl, '/');
        if ($relativePath === '' || strpos($relativePath, '..') !== false) {
            return false;
        }

        if (strpos($relativePath, 'asset/') !== 0) {
            return false;
        }

        $assetRelativePath = substr($relativePath, strlen('asset/'));
        if ($assetRelativePath === '' || strpos($assetRelativePath, '..') !== false) {
            return false;
        }

        $assetPath = APP_ROOT . '/public/' . $assetRelativePath;
        if (!is_file($assetPath)) {
            return false;
        }

        $ext = strtolower(pathinfo($assetPath, PATHINFO_EXTENSION));
        $mimeByExt = [
            'css' => 'text/css; charset=UTF-8',
            'js' => 'application/javascript; charset=UTF-8',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'ico' => 'image/x-icon',
            'webp' => 'image/webp',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2'
        ];

        if (!isset($mimeByExt[$ext])) {
            return false;
        }

        header('Content-Type: ' . $mimeByExt[$ext]);
        header('Content-Length: ' . filesize($assetPath));
        if ($method !== 'HEAD') {
            readfile($assetPath);
        }
        return true;
    }


    public static function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $queryString = urldecode($_SERVER['QUERY_STRING'] ?? '');

        $data = [];
        $queryParams = explode('&', $queryString);
        $_SESSION['query_params'] = $queryParams;
        foreach ($queryParams as $param) {
            if (empty($param)) continue;
            $keyValue = explode('=', $param);
            $key = urldecode($keyValue[0]);
            $value = urldecode($keyValue[1] ?? '');
            if ($key === 'url') continue;
            $data[$key] = $value;
        }

        // body parameters for POST, PUT, PATCH
        if (in_array($method, ['POST', 'PUT', 'PATCH'])) {
            $inputData = file_get_contents('php://input');
            if (!empty($inputData &&
                strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false)) {
                $data['json_data['] = json_decode($inputData, true);
            }
        }
        $cleanedUrl = trim(preg_replace('/\.php$/', '', urldecode($url)), '/');

        if (self::tryServePublicAsset($cleanedUrl, $method)) {
            exit;
        }

        $routeMethod = $method;
        $matchedRoute = self::match($routeMethod, $cleanedUrl);

        // HEAD is allowed to reuse GET route handlers.
        if ($method === 'HEAD' && empty($matchedRoute['action'])) {
            $routeMethod = 'GET';
            $matchedRoute = self::match($routeMethod, $cleanedUrl);
        }

        if (!empty($matchedRoute['action']) && strpos($matchedRoute['action'], '@') !== false) {

            $action = $matchedRoute['action'];
            $params = $matchedRoute['params'] ?? [];
            $data = [...$data, ...$params];
            list($controllerName, $methodName) = explode('@', $action);
            self::invokeControllerMethod($controllerName, $methodName, $routeMethod, $data);
        } else {
            http_response_code(404);
            echo "404 Not Found";
            exit;;
        }
    }
}
