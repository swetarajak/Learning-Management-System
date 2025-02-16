<?php
require_once '../config/database.php';
require_once '../config/response.php';

class UserController{
    private $conn;

    public function __construct() {
        $database = new database();
        $this->conn = $database->getConnection();
    }

    public function register($data){
        try{
            $query = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":name", $data['name']);
            $stmt->bindParam(":email", $data['email']);
            $stmt->bindParam(":password", password_hash($data['password'], PASSWORD_BCRYPT));
            $stmt->bindParam(":role", $data['role']);
            $stmt->execute();
            Response::json(["message" => "User registered sucessfully"], 201);        
        } catch(PDOException $e){
            Response::json(["error" => $e->getMessage()],500);
        }
    }
}
?>