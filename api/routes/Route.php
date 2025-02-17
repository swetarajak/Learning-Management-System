<?php
require_once './config/response.php';
class Route
{
    private static $routes = [];

    public static function add($method, $path, $callback)
    {
        self::$routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'callback' => $callback
        ];
    }

    public static function dispatch()
    {
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            $basePath = '/lms/api';
            $uri = str_replace($basePath, '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

            // echo $uri;
            // Debug the incoming request
            error_log("Dispatching: Method=$method, URI=$uri");
            error_log("Available routes: " . json_encode(self::$routes));


            foreach (self::$routes as $route) {
                if ($method === $route['method'] && $uri === $route['path']) {
                    call_user_func($route['callback']);
                    return;
                }
            }
            Response::json(['message' => 'Route not found'], 404);
        } catch (Exception $e) {
            // http_response_code(404);
            // echo json_encode(["message" => "Route not found"]);
            Response::json(['error' => $e->getMessage()], 404);
        }
    }
}
