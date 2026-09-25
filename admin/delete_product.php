<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

include_once '../config/database.php';

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "Product ID is required.";
    header('Location: admin-products.php');
    exit();
}

$product_id = $_GET['id'];

$database = new Database();
$db = $database->getConnection();

try {
    $query = "DELETE FROM products WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $product_id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Product deleted successfully.";
    } else {
        $_SESSION['error'] = "Unable to delete product.";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
}

header('Location: admin-products.php');
exit();
?>