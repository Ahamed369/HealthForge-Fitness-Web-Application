<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(array("success" => false, "message" => "Unauthorized access."));
    exit();
}

include_once '../config/database.php';
include_once '../models/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name) && !empty($data->email) && !empty($data->password) && !empty($data->role)) {
    $user->name = $data->name;
    $user->email = $data->email;
    $user->password = $data->password;
    
    // Check if email already exists
    if ($user->emailExists()) {
        echo json_encode(array("success" => false, "message" => "Email already exists."));
        exit();
    }
    
    // Create user
    if ($user->register()) {
        // Update role if needed (since register sets default to 'user')
        if ($data->role === 'admin') {
            $query = "UPDATE users SET role = 'admin' WHERE email = :email";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":email", $data->email);
            $stmt->execute();
        }
        
        echo json_encode(array("success" => true, "message" => "User created successfully."));
    } else {
        echo json_encode(array("success" => false, "message" => "Unable to create user."));
    }
} else {
    echo json_encode(array("success" => false, "message" => "All fields are required."));
}
?>