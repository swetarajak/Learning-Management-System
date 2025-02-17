<?php
require_once 'Route.php';
require_once dirname(__DIR__).'/controllers/CourseController.php';

Route::add('GET', '/courses/listCourses', function(){
    $courseController = new CourseController();
    $courseController->listCourses();
});

Route::add('GET', '/courses/createCourses', function(){
    $courseController = new CourseController();
    $courseController->createCourses($_POST);
});

Route::add('GET', '/courses/enroll', function(){
    $courseController = new CourseController();
    $courseController->enroll($_POST);
});

?>