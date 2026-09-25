<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/database.php';
include_once '../models/Cart.php';
include_once '../models/Order.php';

session_start();

if(!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "message" => "Please login first."));
    exit;
}

$database = new Database();
$db = $database->getConnection();

// Get cart items first
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
        'item_total' => $item_total
    );
}

// Check if cart is empty
if(empty($cart_items)) {
    echo json_encode(array("success" => false, "message" => "Your cart is empty."));
    exit;
}

try {
    // Start transaction
    $db->beginTransaction();

    // Create order
    $order = new Order($db);
    $order->user_id = $_SESSION['user_id'];
    $order->order_number = 'HF' . date('YmdHis') . rand(100, 999);
    $order->total_amount = $total;
    $order->status = 'Processing';

    if($order->create()) {
        // Add order items
        foreach($cart_items as $item) {
            if(!$order->addOrderItem($item['product_id'], $item['quantity'], $item['price'])) {
                throw new Exception("Failed to add order item: " . $item['name']);
            }
        }

        // Clear cart after successful order
        if($cart->clearCart()) {
            $db->commit();
            echo json_encode(array(
                "success" => true, 
                "message" => "Order placed successfully! Order #" . $order->order_number,
                "order_number" => $order->order_number,
                "total" => $total
            ));
        } else {
            throw new Exception("Failed to clear cart after order");
        }
    } else {
        throw new Exception("Failed to create order");
    }

} catch (Exception $e) {
    $db->rollBack();
    echo json_encode(array("success" => false, "message" => "Checkout failed: " . $e->getMessage()));
}
?>