<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.html');
    exit();
}

include_once '../config/database.php';
include_once '../models/Order.php';

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);

if ($_POST) {
    $order_number = 'ORD' . date('YmdHis');
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $customer_phone = $_POST['customer_phone'];
    $shipping_address = $_POST['shipping_address'];
    $total_amount = $_POST['total_amount'];
    $status = $_POST['status'];
    
    if ($order->createOrder($order_number, $customer_name, $customer_email, $customer_phone, $shipping_address, $total_amount, $status)) {
        $_SESSION['success'] = "Order created successfully!";
    } else {
        $_SESSION['error'] = "Failed to create order!";
    }
    
    header("Location: admin-orders.php");
    exit();
}
?>