<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include_once '../config/database.php';
include_once '../models/Product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$category = isset($_GET['category']) ? $_GET['category'] : '';
$featured = isset($_GET['featured']) ? true : false;

if($featured) {
    $stmt = $product->readFeatured();
} elseif(!empty($category)) {
    $stmt = $product->readByCategory($category);
} else {
    $stmt = $product->read();
}

$products = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $products[] = array(
        'id' => $row['id'],
        'name' => $row['name'],
        'price' => $row['price'],
        'category' => $row['category'],
        'rating' => $row['rating'],
        'reviews' => $row['reviews'],
        'description' => $row['description'],
        'features' => json_decode($row['features'], true),
        'image' => $row['image']
    );
}

echo json_encode(array("success" => true, "products" => $products));
?>