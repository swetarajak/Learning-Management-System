<?php

require_once 'routes/userRoutes.php';
require_once 'routes/CourseRoutes.php';
require_once 'routes/quizRoutes.php';
require_once 'routes/progressRoutes.php';
require_once 'routes/Route.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// echo "HII";
// Dispatch the route
Route::dispatch();

?>