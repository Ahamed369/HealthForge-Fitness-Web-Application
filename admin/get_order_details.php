<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    exit();
}

include_once '../config/database.php';
include_once '../models/Order.php';

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $order_details = $order->getOrderById($order_id);
    
    if ($order_details) {
        header('Content-Type: application/json');
        echo json_encode($order_details);
    } else {
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['error' => 'Order not found']);
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Order ID required']);
}
?>