<?php
class LoggingMiddleware{
    public static function logRequest(){
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $input = json_encode (file_get_contents('php://input'));

        error_log("[$method] $uri - Input: $input");
    }
}
?>