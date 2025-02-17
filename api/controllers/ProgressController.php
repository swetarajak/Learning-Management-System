<?php
require_once dirname(__DIR__).'/config/database.php';
require_once dirname(__DIR__).'/config/response.php';

class ProgressController{
    private $conn;
    public function __construct(){
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function fetchProgress($student_id, $course_id){
        try{
            $query = "SELECT * FROM progress WHERE student_id=:student_id AND course_id=:course_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":student_id", $student_id);
            $stmt->bindParam(":course_id", $course_id);
            $stmt->execute();
            $progress = $stmt->fetch(PDO::FETCH_ASSOC);
            Response::json($progress,200);
        }catch (PDOException $e){
            Response::json(["message" => "No Progress Found"], 404);
        }
    }
}
?>