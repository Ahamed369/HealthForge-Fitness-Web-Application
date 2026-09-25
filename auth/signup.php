<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/database.php';
include_once '../models/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->name) && !empty($data->email) && !empty($data->password)) {
    $user->name = $data->name;
    $user->email = $data->email;
    $user->password = $data->password;

    if($user->emailExists()) {
        echo json_encode(array("success" => false, "message" => "Email already exists."));
    } else {
        if($user->signup()) {
            // Get the newly created user with role
            $user->email = $data->email;
            if($user->login()) {
                session_start();
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_name'] = $user->name;
                $_SESSION['user_email'] = $user->email;
                $_SESSION['user_role'] = $user->role;
                
                echo json_encode(array(
                    "success" => true, 
                    "message" => "User registered successfully.",
                    "user" => array(
                        "id" => $user->id,
                        "name" => $user->name,
                        "email" => $user->email,
                        "role" => $user->role
                    )
                ));
            } else {
                echo json_encode(array("success" => false, "message" => "Registration successful but login failed. Please login manually."));
            }
        } else {
            echo json_encode(array("success" => false, "message" => "Unable to register user."));
        }
    }
} else {
    echo json_encode(array("success" => false, "message" => "All fields are required."));
}
?>