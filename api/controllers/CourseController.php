<?php
require_once dirname(__DIR__).'/config/database.php';
require_once dirname(__DIR__).'/config/response.php';

class CourseController
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function listCourses()
    {
        try {
            $query = "SELECT * FROM courses";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
            Response::json($courses, 200);
        } catch (PDOException $e) {
            Response::json(["message" => $e->getMessage()], 500);
        }
    }

    public function createCourses($data)
    {
        try {
            $query = "INSERT INTO courses(title, description, category, instructor_id, price) VALUES(:title, :description, :category, :instructor_id, :price)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":title", $data['title']);
            $stmt->bindParam(":description", $data['description']);
            $stmt->bindParam(":category", $data['category']);
            $stmt->bindParam(":price", $data['price']);
            $stmt->execute();
            Response::json(["message" => "Course Created Successfully"], 201);
        } catch (PDOException $e) {
            Response::json(["error" => $e->getMessage()], 500);
        }
    }

    public function enroll($data)
    {
        try {
            $query = "INSERT INTO course_enrollments (course_id, student_id) VALUES (:course_id, :student_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":course_id", $data['course_id']);
            $stmt->bindParam(":student_id", $data['student_id']);
            $stmt->execute();
            Response::json(["message" => "Enrollment SUccessful"], 200);
        } catch (PDOException $e) {
            Response::json(["error" => $e->getMessage()], 500);
        }
    }
}
