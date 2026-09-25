<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include_once '../config/database.php';
include_once '../models/Cart.php';

session_start();

if(!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "message" => "Please login first."));
    exit;
}

$database = new Database();
$db = $database->getConnection();

$cart = new Cart($db);
$cart->user_id = $_SESSION['user_id'];

$stmt = $cart->getCartItems();
$cart_items = array();
$total = 0;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $item_total = $row['price'] * $row['quantity'];
    $total += $item_total;
    
    $cart_items[] = array(
        'id' => $row['id'],
        'product_id' => $row['product_id'],
        'name' => $row['name'],
        'price' => $row['price'],
        'quantity' => $row['quantity'],
        'image' => $row['image'],
        'item_total' => $item_total
    );
}

echo json_encode(array(
    "success" => true,
    "cart_items" => $cart_items,
    "total" => $total,
    "cart_count" => $cart->getCartCount()
));
?>