<?php
require_once 'Route.php';
require_once dirname(__DIR__).'/controllers/ProgressController.php';

Route::add('GET', '/fetchProgress', function(){
    $progressController = new ProgressController();
    $progressController->fetchProgress($_GET['student_id'], $_GET['course_id']);
})
?>