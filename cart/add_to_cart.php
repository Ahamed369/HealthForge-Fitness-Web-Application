<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/database.php';
include_once '../models/Cart.php';

session_start();

// Debug session
error_log("Session user_id: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'NOT SET'));

if(!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "message" => "Please login first. Session not found."));
    exit;
}

$database = new Database();
$db = $database->getConnection();

$cart = new Cart($db);

$data = json_decode(file_get_contents("php://input"));

error_log("Received product_id: " . ($data->product_id ?? 'NOT SET'));

if(!empty($data->product_id)) {
    $cart->user_id = $_SESSION['user_id'];
    $cart->product_id = $data->product_id;
    $cart->quantity = 1;

    if($cart->addToCart()) {
        $cart_count = $cart->getCartCount();
        echo json_encode(array("success" => true, "message" => "Product added to cart.", "cart_count" => $cart_count));
    } else {
        echo json_encode(array("success" => false, "message" => "Unable to add product to cart."));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Product ID is required."));
}
?>