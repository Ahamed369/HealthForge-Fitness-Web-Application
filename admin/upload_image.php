<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(array("success" => false, "message" => "Unauthorized access."));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $uploadDir = '../images/';
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    $maxFileSize = 5 * 1024 * 1024; // 5MB

    $file = $_FILES['image'];
    
    // Check file type
    if (!in_array($file['type'], $allowedTypes)) {
        echo json_encode(array("success" => false, "message" => "Only JPG, PNG, GIF, and WebP images are allowed."));
        exit();
    }
    
    // Check file size
    if ($file['size'] > $maxFileSize) {
        echo json_encode(array("success" => false, "message" => "File size must be less than 5MB."));
        exit();
    }
    
    // Generate unique filename
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = 'product_' . time() . '_' . uniqid() . '.' . $fileExtension;
    $filePath = $uploadDir . $fileName;
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        echo json_encode(array(
            "success" => true, 
            "message" => "Image uploaded successfully.", 
            "filePath" => 'assets/' . $fileName
        ));
    } else {
        echo json_encode(array("success" => false, "message" => "Failed to upload image."));
    }
} else {
    echo json_encode(array("success" => false, "message" => "No image file provided."));
}
?>