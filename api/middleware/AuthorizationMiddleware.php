<!-- Middleware for Role-Based Authorization
This middleware ensures that only users with specific roles (e.g., instructor or student) can access certain routes.

Purpose
Ensures only authorized roles can access specific functionalities.
Restricts actions like course creation, quiz management, etc., based on the user's role. -->

<?php
require_once dirname(__DIR__) .'/middleware/AuthenticationMiddleware.php';

class AuthorizationMiddleware{
    public static function authorize($roles=[]){
        $user = AuthenticationMiddleware::authenticate();
        if(!in_array($user->role, $roles)){
            Response::json(["error" => "Acess denied"],403);
        }
        return $user;
    }
}
?>