<?php
require_once dirname(__DIR__).'/config/database.php';
require_once dirname(__DIR__).'/config/response.php';

class QuizController{
    private $conn;

    public function __construct(){
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function createQuiz($data){
        try{
            $query = "INSERT INTO quizzes(course_id, title) VALUES (:course_id, :title)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":course_id", $data['course_id']);
            $stmt->bindParam(":title", $data['title']);
            $stmt->execute();
            Response::json(["message" => "Quizz Created Successfully"], 201);
        } catch (PDOException $e){
            Response::json(["error" => $e->getMessage()], 500);
        }
    }
    public function addQuestions($data){
        try{
            $query = "INSERT INTO questions (quiz_id, questions, options, correct_option) VALUES (:quiz_id, :question, :options, :correct_option)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":quiz_id", $data['quiz_id']);
            $stmt->bindParam(":question", $data['question']);
            $stmt->bindParam(':options', $data['options']);
            $stmt->bindParam(":correct_option", $data['correct_option']);
            $stmt->execute();
            Response::json(["message" => "Questions added successfully"], 201);
        } catch (PDOException $e){
            Response::json(["message"=>"Failed to add questions"], 500);
        }
        
    }
}
?>