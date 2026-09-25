<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

session_start();

// Start output buffering to prevent any accidental output
ob_start();

if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    echo json_encode(array(
        "success" => true,
        "user" => array(
            "id" => $_SESSION['user_id'],
            "name" => $_SESSION['user_name'],
            "email" => $_SESSION['user_email'],
            "role" => $_SESSION['user_role']
        )
    ));
} else {
    echo json_encode(array(
        "success" => false, 
        "message" => "Not logged in",
        "session_data" => $_SESSION // For debugging
    ));
}

// Clean output buffer
ob_end_flush();
?>