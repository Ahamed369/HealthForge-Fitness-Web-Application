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
    
    $id = $_POST['id'];
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    
    try {
        $query = "UPDATE faqs SET question = :question, answer = :answer WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':question', $question);
        $stmt->bindParam(':answer', $answer);
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "FAQ updated successfully.";
        } else {
            $_SESSION['error'] = "Failed to update FAQ.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}

header('Location: admin-faq.php');
exit();
?>