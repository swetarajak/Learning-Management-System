<?php
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/config/response.php';
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Dotenv\Dotenv;

class UserController
{

    private $conn;
    private  $SECRET_KEY;
    // private $secret_key = $SECRET_KEY ;

    public function __construct()
    {
        // Load the environment variables
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();
        // Initialize secret key from .env
        $this->SECRET_KEY = $_ENV['SECRET_KEY'] ?? null;
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function register($data)
    {
        try {

            // Assign POST data to variables
            $name = $data['name'];
            $email = $data['email'];
            $password = password_hash($data['password'], PASSWORD_DEFAULT); // Hash password
            $role = $data['role'];

            // Check if the email already exists
            $query = "SELECT COUNT(*) as count FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['count'] > 0) {
                Response::json(['error' => 'Email already exists'], 409);
                return;
            }

            // Prepare and execute the query
            $query = "INSERT INTO users (name, email, password,role) VALUES (:name, :email, :password,:role)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role', $role);
            $stmt->execute();

            // Retrieve the inserted user ID
            $userId = $this->conn->lastInsertId();
            // Generate a JWT token
            $payload = [
                "id" => $userId,
                "email" => $data['email'],
                "role" => $data['role'],
                "exp" => time() + 3600 // Token valid for 1 hour
            ];

            $jwt = JWT::encode($payload, $this->SECRET_KEY, 'HS256');

            // Return the token and user details
            Response::json([
                'message' => 'User registered successfully',
                'token' => $jwt,
                'user' => [
                    'id' => $userId,
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'role' => $data['role']
                ]
            ], 201);
        } catch (PDOException $e) {
            Response::json(['error' => $e->getMessage()], 500);
        } catch (Exception $e) {
            Response::json(['error' => 'An unexpected error occurred'], 500);
        }
    }
    public function login($data)
    {
        try {
            // Extract validated data from $data
            $email = $data['email'];
            $password = $data['password'];

            $query = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($password, $user['password'])) {
                // Generate JWT
                $payload = [
                    "id" => $user['id'],
                    "email" => $user['email'],
                    "role" => $user['role'],
                    "exp" => time() + 3600 // Token valid for 1 hour
                ];

                $jwt = JWT::encode($payload, $this->SECRET_KEY, 'HS256');
                Response::json(["token" => $jwt, "message" => "Login Successful", "user" => $user], 200);
            } else {
                Response::json(["message" => "Invalid Credentials"], 401);
            }
        } catch (PDOException $e) {
            Response::json(["error" => $e->getMessage()], 500);
        }
    }
}
