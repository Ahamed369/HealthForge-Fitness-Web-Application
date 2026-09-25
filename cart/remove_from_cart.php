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

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->cart_item_id)) {
    $cart->id = $data->cart_item_id;
    $cart->user_id = $_SESSION['user_id'];

    if($cart->removeFromCart()) {
        echo json_encode(array("success" => true, "message" => "Item removed from cart."));
    } else {
        echo json_encode(array("success" => false, "message" => "Unable to remove item from cart."));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Cart item ID is required."));
}
?>