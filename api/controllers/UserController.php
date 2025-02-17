<?php
require_once dirname(__DIR__).'/config/database.php';
require_once dirname(__DIR__).'/config/response.php';

class UserController{
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function register($data){
        try {
            // Validate required fields
            if (!isset($data['name'], $data['email'], $data['password'])) {
                Response::json(['error' => 'Missing required fields: name, email, or password'], 400);
                return;
            }
    
            // Assign POST data to variables
            $name = $data['name'];
            $email = $data['email'];
            $password = password_hash($data['password'], PASSWORD_DEFAULT); // Hash password
            $role = $data['role'];
            // Prepare and execute the query
            $query = "INSERT INTO users (name, email, password,role) VALUES (:name, :email, :password,:role)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role', $role);
            $stmt->execute();
    
            Response::json(['message' => 'User registered successfully'], 201);
        } catch (PDOException $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }
        public function login($data){
        try{
            $query = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $data['email']);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if($user && password_verify($data['password'], $user['password'])){
                Response::json(["message" => "Login Successful", "user" => $user], 200);
            }else{
                Response::json(["message" => "Invalid Credentials"], 401);
            }
            } catch(PDOException $e){
                Response::json(["error" => $e->getMessage()],500);
         }
    }
}
?>