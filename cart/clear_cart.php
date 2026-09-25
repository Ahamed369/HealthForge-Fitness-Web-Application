<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

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

if($cart->clearCart()) {
    echo json_encode(array("success" => true, "message" => "Cart cleared successfully."));
} else {
    echo json_encode(array("success" => false, "message" => "Unable to clear cart."));
}
?>