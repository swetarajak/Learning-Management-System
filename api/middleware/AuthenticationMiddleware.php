<!-- This middleware ensures that the user has a valid JWT token and is authenticated before accessing any protected route.

Purpose
Verifies the presence of a token in the Authorization header.
Decodes the token and validates it using your secret key.
Returns the user information (ID and role) for further use in the request. -->

<?php
require_once dirname(__DIR__).'/../vendor/autoload.php';
require_once dirname(__DIR__).'/config/response.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthenticationMiddleware{
    private static $secret_key = "";

    public static function authenticate(){
        $headers = apache_request_headers();
        if(!isset($headers['Authorization'])){
            Response::json(["error"=>"Authentication header not found"], 401);
        }

        $token = str_replace('Bearer ','',$headers['Authorization']);
        try{
            $decoded = JWT::decode($token, new Key(self::$secret_key, 'HS256'));
            return $decoded->data; //Return user data
        }catch (Exception $e){
            Response::json(["error" => "Invalid token" . $e->getMessage()], 401);
        }
    }
}
?>