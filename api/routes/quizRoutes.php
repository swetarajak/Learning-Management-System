<?php
require_once 'Route.php';
require_once dirname(__DIR__) . '/controllers/QuizController.php';

// Route to create a quiz
Route::add('POST', '/quiz/createQuiz', function () {
    $quizController = new QuizController();
    $data = json_decode(file_get_contents("php://input"), true);
    $quizController->createQuiz($data);
});

// Route to add questions
Route::add('POST', '/quiz/addQuestions', function () {
    $quizController = new QuizController();
    $data = json_decode(file_get_contents("php://input"), true);
    $quizController->addQuestions($data);
});
?>
