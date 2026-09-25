<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

include_once '../config/database.php';
include_once '../models/Order.php';

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "Order ID is required.";
    header('Location: admin-orders.php');
    exit();
}

$order_id = $_GET['id'];

$database = new Database();
$db = $database->getConnection();
$order = new Order($db);

if ($order->deleteOrder($order_id)) {
    $_SESSION['success'] = "Order deleted successfully!";
} else {
    $_SESSION['error'] = "Failed to delete order!";
}

header("Location: admin-orders.php");
exit();
?>