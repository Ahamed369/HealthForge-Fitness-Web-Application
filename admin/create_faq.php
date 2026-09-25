<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

include_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    
    try {
        $query = "INSERT INTO faqs (question, answer) VALUES (:question, :answer)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':question', $question);
        $stmt->bindParam(':answer', $answer);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "FAQ created successfully.";
        } else {
            $_SESSION['error'] = "Failed to create FAQ.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}

header('Location: admin-faq.php');
exit();
?>