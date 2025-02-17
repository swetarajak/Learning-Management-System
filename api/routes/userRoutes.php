<?php
require_once 'Route.php';
require_once dirname(__DIR__) . '/controllers/UserController.php';

Route::add('POST', '/user/register', function(){
    $userController = new UserController();
    $userController->register($_POST);
});

Route::add('GET', '/user/login', function(){
    $userController = new UserController();
    $userController->login($_GET);
});

?>