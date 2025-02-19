<!-- This middleware validates the incoming request payload to ensure that required fields are provided and are in the correct format.

Purpose
Prevents SQL injection or invalid data from being passed to the controllers.
Checks the request body for required fields. -->

<?php
require_once dirname(__DIR__) . '/config/response.php';
class ValidationMiddleware{
    public static function validate($data, $requiredFields){
        foreach($requiredFields as $field){
            if(!isset($data[$field]) || empty($data[$field])){
                Response::json(["error" => `{$field} is required`], 400);
            }
        }
    }
}
?>